# Foothill Gold Line

This repository is for Foothill Gold Line website development.

It contains the WordPress themes and plugins used by the project:

- `themes/foothill-gold-line/` — the custom Foothill Gold Line theme.
- `themes/` — additional WordPress themes.
- `plugins/` — WordPress plugins.

## Local development

Use a local WordPress installation and place this repository's `themes/` and
`plugins/` directories in its `wp-content/` directory. Activate the Foothill Gold
Line theme and the plugins needed for your local site.

WordPress core, database content, uploads, and environment-specific configuration
are not included in this repository.

## SFTP deployment

`.github/workflows/deploy-sftp.yml` deploys pushes to `main` that change
`themes/`, `plugins/events/`, `plugins/construction-maps/`, or the deployment
workflow/script. It can also be run from GitHub Actions using **Run workflow**
on `main`. PHP syntax is checked before connecting to the server.

Configure these repository Actions secrets:

| Secret | Value |
| --- | --- |
| `SFTP_HOST` | SFTP hostname, without a protocol prefix |
| `SFTP_PORT` | SFTP port; defaults to `22` if empty |
| `SFTP_USERNAME` | SFTP username |
| `SFTP_PASSWORD` | SFTP password |
| `SFTP_REMOTE_PATH` | Existing remote `wp-content` directory containing `themes` and `plugins` |
| `SFTP_KNOWN_HOSTS` | Verified OpenSSH known_hosts entries for the server |

For a nonstandard port, the known_hosts entry starts with `[hostname]:port`.
Obtain the server's host key through a trusted connection or your hosting
provider and verify its fingerprint before saving it. Unknown or changed host
keys stop deployment before password authentication.

Every deployment uploads all Git-tracked files under the three selected paths,
including all themes. Other plugins, uploads, database content, and WordPress
core are outside the deployment scope. Remote files are never deleted, so
removed or renamed files must be cleaned up separately when appropriate.
Uploads overwrite files in place; this is not an atomic release, and a failed
deployment can leave a mix of versions. Rerun the workflow after resolving a
failure to upload the complete set again.
