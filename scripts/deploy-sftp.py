"""Upload tracked WordPress code to an existing remote wp-content directory."""

import errno
import os
from pathlib import Path, PurePosixPath
import posixpath
import stat
import subprocess
import tempfile

import paramiko


ROOT = Path(__file__).resolve().parents[1]
DEPLOY_PATHS = (
    "themes",
    "plugins/events",
    "plugins/construction-maps",
    "plugins/construction-notice-widgets",
    "plugins/stations-widget",
)


def required(name):
    value = os.environ.get(name, "")
    if not value.strip():
        raise ValueError(f"Missing required environment variable: {name}")
    return value


def deployment_files():
    output = subprocess.check_output(
        ["git", "ls-files", "-z", "--", *DEPLOY_PATHS], cwd=ROOT
    )
    files = []
    for name in output.decode().split("\0"):
        if not name:
            continue
        relative = PurePosixPath(name)
        local = ROOT / name
        if relative.is_absolute() or ".." in relative.parts:
            raise ValueError(f"Invalid deployment path: {name}")
        if any((ROOT.joinpath(*relative.parts[:i])).is_symlink()
               for i in range(1, len(relative.parts) + 1)):
            raise ValueError(f"Symlinks cannot be deployed: {name}")
        if not local.is_file():
            raise ValueError(f"Missing tracked file: {name}")
        files.append((name, local))
    for prefix in DEPLOY_PATHS:
        if not any(name.startswith(prefix + "/") for name, _ in files):
            raise ValueError(f"No tracked files under {prefix}")
    return files


def ensure_directory(sftp, path, created):
    if path in created:
        return
    try:
        attributes = sftp.lstat(path)
    except OSError as error:
        if error.errno != errno.ENOENT:
            raise
        ensure_directory(sftp, posixpath.dirname(path), created)
        sftp.mkdir(path)
    else:
        if not stat.S_ISDIR(attributes.st_mode):
            raise ValueError(f"Remote path is not a directory: {path}")
    created.add(path)


def upload(sftp, remote_root, files):
    # Require an existing destination to catch mistyped paths before uploading.
    remote_root = sftp.normalize(remote_root)
    if not stat.S_ISDIR(sftp.stat(remote_root).st_mode):
        raise ValueError("SFTP_REMOTE_PATH must be an existing wp-content directory")
    # These directories identify the expected WordPress content layout.
    for directory in ("themes", "plugins"):
        if not stat.S_ISDIR(sftp.lstat(posixpath.join(remote_root, directory)).st_mode):
            raise ValueError(f"Remote wp-content is missing directory: {directory}")
    created = {remote_root}
    for name, local in files:
        destination = posixpath.join(remote_root, name)
        ensure_directory(sftp, posixpath.dirname(destination), created)
        try:
            attributes = sftp.lstat(destination)
        except OSError as error:
            if error.errno != errno.ENOENT:
                raise
        else:
            if not stat.S_ISREG(attributes.st_mode):
                raise ValueError(f"Remote destination is not a regular file: {name}")
        sftp.put(str(local), destination, confirm=True)
        print(f"Uploaded {name}", flush=True)
    print(f"Deployed {len(files)} files. No remote files were deleted.")


def main():
    host = required("SFTP_HOST").strip()
    port = int(os.environ.get("SFTP_PORT", "").strip() or "22")
    if not 1 <= port <= 65535:
        raise ValueError("SFTP_PORT must be between 1 and 65535")
    username = required("SFTP_USERNAME")
    password = required("SFTP_PASSWORD")
    remote_root = required("SFTP_REMOTE_PATH").strip()
    known_hosts = required("SFTP_KNOWN_HOSTS")
    files = deployment_files()
    with tempfile.NamedTemporaryFile(mode="w+", encoding="utf-8") as key_file:
        key_file.write(known_hosts + "\n")
        key_file.flush()
        with paramiko.SSHClient() as client:
            client.load_host_keys(key_file.name)
            client.set_missing_host_key_policy(paramiko.RejectPolicy())
            client.connect(
                hostname=host, port=port, username=username, password=password,
                allow_agent=False, look_for_keys=False,
                timeout=30, banner_timeout=30, auth_timeout=30,
            )
            client.get_transport().set_keepalive(30)
            with client.open_sftp() as sftp:
                sftp.get_channel().settimeout(60)
                upload(sftp, remote_root, files)


if __name__ == "__main__":
    main()
