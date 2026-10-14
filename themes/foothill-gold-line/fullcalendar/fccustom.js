// Scroll to function
jQuery.fn.scrollTo = function (elem, speed) {
  $(this).animate(
    {
      scrollTop:
        $(this).scrollTop() - $(this).offset().top + $(elem).offset().top,
    },
    speed == undefined ? 1000 : speed
  );
  return this;
};

// Get Date and Event ID Query Param to set up calendar month
var eventQueryString = window.location.search;
var eventUrlParams = new URLSearchParams(eventQueryString);
// Get the values of 'eventid' and 'date'
var paramEventId = eventUrlParams.get("eventid");
var paramDefaultDate = eventUrlParams.get("date");

// Timestamp
var cacheBust = new Date().getTime();

$(document).ready(function () {
  /* Events from Wordpress */
  $("#calendarfc").fullCalendar({
    defaultDate: paramDefaultDate,
    events: {
      url: "https://foothillgold.wpenginepowered.com/wp-content/uploads/events_feed/event_feed.json?time=" + cacheBust,
      data: {},
      success: function (data) {
        var events = [];
        $.each(data, function (index) {
          //alert(data[index]);
          for (var key in data[index]) {
            //					//alert(typeof data[index][key]);

            if (typeof data[index][key] == "object") {
              //					   //alert("Nested");
              for (x in data[index][key]) {
                if (typeof data[index][key][x] == "object") {
                  //								alert(data[index][key][x][y])
                  for (y in data[index][key][x]) {
                    var obj = {};
                    obj[y] = data[index][key][x][y];
                    events.push(obj);
                    //alert( y + " = " + data[index][key][x][y]);
                  }
                } else {
                  //alert (x + " = " + data[index][key][x]);
                  var obj = {};
                  obj[x] = data[index][key][x];
                  events.push(obj);

                  ////alert(data[index][key][x]); = GETS X's value
                  ////alert(x); x = category / ACF field name
                }
              }
            } else {
              //alert(key + " = " + data[index][key]);
              var obj = {};
              obj[key] = data[index][key];
              events.push(obj);
              ////alert(key); key = id, title, etc.
              ////alert(data[index][key]);  = GETS Key's Value
            }

            //					//alert(Object.entries(data[index][x]));

            //}
          }
          events.push({
            title: data[index].item,
            start: data[index].bestbefore,
          });
        });
        //test logic to see if saved
        //alert(JSON.stringify(events));
      },
      error: function () {
        //alert("Broken");
      },
    },
    header: {
      left: "",
      center: "title",
      right: "",
    },
    buttonIcons: {
      prev: "calprev",
      next: "calnext",
    },
    showNonCurrentDates: false,
    eventColor: "#f1efee",
    columnFormat: "dddd",
    displayEventTime: false,
    //showNonCurrentDates: false,
    height: "parent",
    /* Rendering of events */
    eventRender: function (event, element) {
      element.attr("href", "javascript:void(0);");
      /* On click of event find class that equals id */

      /* Replace the Title with the Event Category */
      /*var eventCat = event._taxonomies[0].eventcat;
			if (eventCat != undefined) {
				element.find(".fc-title").html(event._taxonomies[0].eventcat);
			};*/

      /*Replace the Title with the Event Category */
      var eventCat = event.eventCat;
      if (eventCat != undefined) {
        element.find(".fc-title").html(event.eventCat);
      }

      /* Add Event Slug as Class */
      var eventCSlug = event.eventCatSlug;
      if (eventCSlug != undefined) {
        element.find(".fc-content").addClass(event.eventCatSlug);
      }

      /* Add Event Slug as Class */
      var eventId = event.idEvent;
      if (eventId != undefined) {
        element.find(".fc-content").attr("id", "eventnum-" + event.idEvent);
      }

      /* If Cancelled add class */
      var eventCancelled = event.eventcancelled;
      if (eventCancelled === true) {
        element.find(".fc-content").addClass("eventcancelled");
      }
    },
    defaultView: "month",
    editable: false,

    /* Onclick */
    eventClick: function () {
      $(".fc-widget-content").removeClass("yepitsgood");
      var theeventid = $(this).find(".fc-content").attr("id");
      $("." + theeventid).addClass("yepitsgood");

      // For mobile scroll
      if (window.matchMedia("(max-width: 900px)").matches) {
        jQuery([document.documentElement, document.body]).animate(
          {
            scrollTop: jQuery("." + theeventid).offset().top,
          },
          1000
        );
      } else {
        $("#contentRight").scrollTo("." + theeventid, 1000);
      }
    },
    eventAfterAllRender: function (view) {
      queryParamScrollTo();
    },
  });
});

/*************************
Right Side List of Events
*************************/

/************ BOARD **************/

$(document).ready(function () {
  /* Events from Wordpress */
  $("#boardCalList").fullCalendar({
    defaultDate: paramDefaultDate,
    events: {
      url: "https://foothillgold.wpenginepowered.com/wp-content/uploads/events_feed/event_feed_board.json?time=" + cacheBust,
      data: {},
      success: function (data) {
        var events = [];
        $.each(data, function (index) {
          //alert(data[index]);
          for (var key in data[index]) {
            //					//alert(typeof data[index][key]);

            if (typeof data[index][key] == "object") {
              //					   //alert("Nested");
              for (x in data[index][key]) {
                if (typeof data[index][key][x] == "object") {
                  //								alert(data[index][key][x][y])
                  for (y in data[index][key][x]) {
                    var obj = {};
                    obj[y] = data[index][key][x][y];
                    events.push(obj);
                    //alert( y + " = " + data[index][key][x][y]);
                  }
                } else {
                  //alert (x + " = " + data[index][key][x]);
                  var obj = {};
                  obj[x] = data[index][key][x];
                  events.push(obj);

                  ////alert(data[index][key][x]); = GETS X's value
                  ////alert(x); x = category / ACF field name
                }
              }
            } else {
              //alert(key + " = " + data[index][key]);
              var obj = {};
              obj[key] = data[index][key];
              events.push(obj);
              ////alert(key); key = id, title, etc.
              ////alert(data[index][key]);  = GETS Key's Value
            }

            //					//alert(Object.entries(data[index][x]));

            //}
          }
          events.push({
            title: data[index].item,
            start: data[index].bestbefore,
          });
        });
        //test logic to see if saved
        //alert(JSON.stringify(events));
      },
      error: function () {
        //alert("Broken");
      },
    },
    header: {
      left: "",
      center: "",
      right: "",
    },
    contentHeight: "auto",
    views: {
      listMonth: {
        type: "list",
        duration: { months: 1 },
        noEventsMessage: "No upcoming events for this month.",
      },
    },
    eventColor: "#f1efee",
    columnFormat: "dddd",
    defaultView: "listMonth",
    editable: false,

    /* Rendering of events */
    eventRender: function (event, element) {
      /* Replace the Title with the Event Category */
      var eventCat = event._taxonomies[0].eventcat;
      if (eventCat != undefined) {
        element.find(".fc-title").html(event._taxonomies[0].eventcat);
      }

      /* Event Slug as class*/
      var eventCSlug = event.eventCatSlug;
      if (eventCSlug != undefined) {
        element.find(".fc-content").addClass(event.eventCatSlug);
      }

      /* Rendering for listed events */
      element
        .find(".fc-list-item-title")
        .html(moment(event.start).format("h:mm A"));

      element
        .find(".fc-list-item-marker")
        .html(
          '<span class="caleventtitle">' +
            event.title +
            '</span><span class="callocation">' +
            event.location +
            "</span>"
        );

      element
        .find(".fc-list-item-time")
        .html(moment(event.start).format("MMM Do, YYYY"));

      /* Get Content if it exists */
      var eventContent = event.content;
      if (eventContent != "") {
        element
          .find(".callocation")
          .append(
            '<div class="caleventcontentmore">more info</div><div class="caleventcontent">' +
              event.content +
              "</div>"
          );
        element.find(".caleventcontentmore").click(function () {
          $(this).next(".caleventcontent").slideToggle();
        });
      }

      //Event Attachments
      var eventAttachmentOne = event.attachmentonefile;
      if (eventAttachmentOne != undefined && eventAttachmentOne != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentonefile +
              '" class="calattachment">' +
              event.attachmentonename +
              "</a>"
          );
      }
      var eventAttachmentTwo = event.attachmenttwofile;
      if (eventAttachmentTwo != undefined && eventAttachmentTwo != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmenttwofile +
              '" class="calattachment">' +
              event.attachmenttwoname +
              "</a>"
          );
      }
      var eventAttachmentThree = event.attachmentthreefile;
      if (eventAttachmentThree != undefined && eventAttachmentThree != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentthreefile +
              '" class="calattachment">' +
              event.attachmentthreename +
              "</a>"
          );
      }
      var eventAttachmentFour = event.attachmentfourfile;
      if (eventAttachmentFour != undefined && eventAttachmentFour != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentfourfile +
              '" class="calattachment">' +
              event.attachmentfourname +
              "</a>"
          );
      }

      /* Add Event Slug as Class */
      var eventId = event.idEvent;
      if (eventId != undefined) {
        element
          .find(".fc-list-item-marker")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-title")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-time")
          .addClass("eventnum-" + event.idEvent);
      }

      /* If Cancelled add class */
      var eventCancelled = event.eventcancelled;
      if (eventCancelled === true) {
        element
          .find(".fc-list-item-marker.fc-widget-content")
          .addClass("eventcancelled");
      }
    },
    eventAfterAllRender: function (view) {
      queryParamScrollTo();
    },
  });
});

/************ JPA **************/

$(document).ready(function () {
  /* Events from Wordpress */
  $("#jpaCalList").fullCalendar({
    defaultDate: paramDefaultDate,
    events: {
      url: "https://foothillgold.wpenginepowered.com/wp-content/uploads/events_feed/event_feed_jpa.json?time=" + cacheBust,
      data: {},
      success: function (data) {
        var events = [];
        $.each(data, function (index) {
          //alert(data[index]);
          for (var key in data[index]) {
            //					//alert(typeof data[index][key]);

            if (typeof data[index][key] == "object") {
              //					   //alert("Nested");
              for (x in data[index][key]) {
                if (typeof data[index][key][x] == "object") {
                  //								alert(data[index][key][x][y])
                  for (y in data[index][key][x]) {
                    var obj = {};
                    obj[y] = data[index][key][x][y];
                    events.push(obj);
                    //alert( y + " = " + data[index][key][x][y]);
                  }
                } else {
                  //alert (x + " = " + data[index][key][x]);
                  var obj = {};
                  obj[x] = data[index][key][x];
                  events.push(obj);

                  ////alert(data[index][key][x]); = GETS X's value
                  ////alert(x); x = category / ACF field name
                }
              }
            } else {
              //alert(key + " = " + data[index][key]);
              var obj = {};
              obj[key] = data[index][key];
              events.push(obj);
              ////alert(key); key = id, title, etc.
              ////alert(data[index][key]);  = GETS Key's Value
            }

            //					//alert(Object.entries(data[index][x]));

            //}
          }
          events.push({
            title: data[index].item,
            start: data[index].bestbefore,
          });
        });
        //test logic to see if saved
        //alert(JSON.stringify(events));
      },
      error: function () {
        //alert("Broken");
      },
    },
    header: {
      left: "",
      center: "",
      right: "",
    },
    contentHeight: "auto",
    views: {
      listMonth: {
        type: "list",
        duration: { months: 1 },
        noEventsMessage: "No upcoming events for this month.",
      },
    },
    eventColor: "#f1efee",
    columnFormat: "dddd",
    defaultView: "listMonth",
    editable: false,

    /* Rendering of events */
    eventRender: function (event, element) {
      /* Replace the Title with the Event Category */
      var eventCat = event._taxonomies[0].eventcat;
      if (eventCat != undefined) {
        element.find(".fc-title").html(event._taxonomies[0].eventcat);
      }

      /* Event Slug as class*/
      var eventCSlug = event.eventCatSlug;
      if (eventCSlug != undefined) {
        element.find(".fc-content").addClass(event.eventCatSlug);
      }

      /* Rendering for listed events */
      element
        .find(".fc-list-item-title")
        .html(moment(event.start).format("h:mm A"));

      element
        .find(".fc-list-item-marker")
        .html(
          '<span class="caleventtitle">' +
            event.title +
            '</span><span class="callocation">' +
            event.location +
            "</span>"
        );

      element
        .find(".fc-list-item-time")
        .html(moment(event.start).format("MMM Do, YYYY"));

      /* Get Content if it exists */
      var eventContent = event.content;
      if (eventContent != "") {
        element
          .find(".callocation")
          .append(
            '<div class="caleventcontentmore">more info</div><div class="caleventcontent">' +
              event.content +
              "</div>"
          );
        element.find(".caleventcontentmore").click(function () {
          $(this).next(".caleventcontent").slideToggle();
        });
      }

      ///Event Attachments
      var eventAttachmentOne = event.attachmentonefile;
      if (eventAttachmentOne != undefined && eventAttachmentOne != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentonefile +
              '" class="calattachment">' +
              event.attachmentonename +
              "</a>"
          );
      }
      var eventAttachmentTwo = event.attachmenttwofile;
      if (eventAttachmentTwo != undefined && eventAttachmentTwo != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmenttwofile +
              '" class="calattachment">' +
              event.attachmenttwoname +
              "</a>"
          );
      }
      var eventAttachmentThree = event.attachmentthreefile;
      if (eventAttachmentThree != undefined && eventAttachmentThree != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentthreefile +
              '" class="calattachment">' +
              event.attachmentthreename +
              "</a>"
          );
      }
      var eventAttachmentFour = event.attachmentfourfile;
      if (eventAttachmentFour != undefined && eventAttachmentFour != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentfourfile +
              '" class="calattachment">' +
              event.attachmentfourname +
              "</a>"
          );
      }

      /* Add Event Slug as Class */
      var eventId = event.idEvent;
      if (eventId != undefined) {
        element
          .find(".fc-list-item-marker")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-title")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-time")
          .addClass("eventnum-" + event.idEvent);
      }

      /* If Cancelled add class */
      var eventCancelled = event.eventcancelled;
      if (eventCancelled === true) {
        element
          .find(".fc-list-item-marker.fc-widget-content")
          .addClass("eventcancelled");
      }
    },
    eventAfterAllRender: function (view) {
      queryParamScrollTo();
    },
  });
});

/************ COMMUNITY **************/

$(document).ready(function () {
  /* Events from Wordpress */
  $("#communityCalList").fullCalendar({
    defaultDate: paramDefaultDate,
    events: {
      url: "https://foothillgold.wpenginepowered.com/wp-content/uploads/events_feed/event_feed_community.json?time=" + cacheBust,
      data: {},
      success: function (data) {
        var events = [];
        $.each(data, function (index) {
          //alert(data[index]);
          for (var key in data[index]) {
            //					//alert(typeof data[index][key]);

            if (typeof data[index][key] == "object") {
              //					   //alert("Nested");
              for (x in data[index][key]) {
                if (typeof data[index][key][x] == "object") {
                  //								alert(data[index][key][x][y])
                  for (y in data[index][key][x]) {
                    var obj = {};
                    obj[y] = data[index][key][x][y];
                    events.push(obj);
                    //alert( y + " = " + data[index][key][x][y]);
                  }
                } else {
                  //alert (x + " = " + data[index][key][x]);
                  var obj = {};
                  obj[x] = data[index][key][x];
                  events.push(obj);

                  ////alert(data[index][key][x]); = GETS X's value
                  ////alert(x); x = category / ACF field name
                }
              }
            } else {
              //alert(key + " = " + data[index][key]);
              var obj = {};
              obj[key] = data[index][key];
              events.push(obj);
              ////alert(key); key = id, title, etc.
              ////alert(data[index][key]);  = GETS Key's Value
            }

            //					//alert(Object.entries(data[index][x]));

            //}
          }
          events.push({
            title: data[index].item,
            start: data[index].bestbefore,
          });
        });
        //test logic to see if saved
        //alert(JSON.stringify(events));
      },
      error: function () {
        //alert("Broken");
      },
    },
    header: {
      left: "",
      center: "",
      right: "",
    },
    contentHeight: "auto",
    views: {
      listMonth: {
        type: "list",
        duration: { months: 1 },
        noEventsMessage: "No upcoming events for this month.",
      },
    },
    eventColor: "#f1efee",
    columnFormat: "dddd",
    defaultView: "listMonth",
    editable: false,

    /* Rendering of events */
    eventRender: function (event, element) {
      /* Replace the Title with the Event Category */
      var eventCat = event._taxonomies[0].eventcat;
      if (eventCat != undefined) {
        element.find(".fc-title").html(event._taxonomies[0].eventcat);
      }

      /* Event Slug as class*/
      var eventCSlug = event.eventCatSlug;
      if (eventCSlug != undefined) {
        element.find(".fc-content").addClass(event.eventCatSlug);
      }

      /* Rendering for listed events */
      element
        .find(".fc-list-item-title")
        .html(moment(event.start).format("h:mm A"));

      element
        .find(".fc-list-item-marker")
        .html(
          '<span class="caleventtitle">' +
            event.title +
            '</span><span class="callocation">' +
            event.location +
            "</span>"
        );

      element
        .find(".fc-list-item-time")
        .html(moment(event.start).format("MMM Do, YYYY"));

      /* Get Content if it exists */
      var eventContent = event.content;
      if (eventContent != "") {
        element
          .find(".callocation")
          .append(
            '<div class="caleventcontentmore">more info</div><div class="caleventcontent">' +
              event.content +
              "</div>"
          );
        element.find(".caleventcontentmore").click(function () {
          $(this).next(".caleventcontent").slideToggle();
          $(this).toggleClass("caleventmoreactive");
        });
      }

      //Event Attachments
      var eventAttachmentOne = event.attachmentonefile;
      if (eventAttachmentOne != undefined && eventAttachmentOne != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentonefile +
              '" class="calattachment">' +
              event.attachmentonename +
              "</a>"
          );
      }
      var eventAttachmentTwo = event.attachmenttwofile;
      if (eventAttachmentTwo != undefined && eventAttachmentTwo != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmenttwofile +
              '" class="calattachment">' +
              event.attachmenttwoname +
              "</a>"
          );
      }
      var eventAttachmentThree = event.attachmentthreefile;
      if (eventAttachmentThree != undefined && eventAttachmentThree != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentthreefile +
              '" class="calattachment">' +
              event.attachmentthreename +
              "</a>"
          );
      }
      var eventAttachmentFour = event.attachmentfourfile;
      if (eventAttachmentFour != undefined && eventAttachmentFour != false) {
        element
          .find(".fc-list-item-marker")
          .append(
            '<a href="' +
              event.attachmentfourfile +
              '" class="calattachment">' +
              event.attachmentfourname +
              "</a>"
          );
      }

      /* Add Event Slug as Class */
      var eventId = event.idEvent;
      if (eventId != undefined) {
        element
          .find(".fc-list-item-marker")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-title")
          .addClass("eventnum-" + event.idEvent);
        element
          .find(".fc-list-item-time")
          .addClass("eventnum-" + event.idEvent);
      }

      /* If Cancelled add class */
      var eventCancelled = event.eventcancelled;
      if (eventCancelled === true) {
        element
          .find(".fc-list-item-marker.fc-widget-content")
          .addClass("eventcancelled");
      }
    },
    eventAfterAllRender: function (view) {
      queryParamScrollTo();
    },
  });
});

/* On click function for changing months on right side calendar */

$(document).ready(function () {
  $("#calendarprev").on("click", function () {
    $("#calendarfc").fullCalendar("prev"); // call method
    $("#boardCalList").fullCalendar("prev"); // call method
    $("#communityCalList").fullCalendar("prev"); // call method
    $("#jpaCalList").fullCalendar("prev"); // call method
    scrollTopAdaptive();
  });
  $("#calendarnext").on("click", function () {
    $("#calendarfc").fullCalendar("next"); // call method
    $("#communityCalList").fullCalendar("next"); // call method
    $("#boardCalList").fullCalendar("next"); // call method
    $("#jpaCalList").fullCalendar("next"); // call method
    scrollTopAdaptive();
  });

  /* Prepend the Table Heading for Lists */
  $("#boardCalList").prepend(
    '<table class="callistheader"><tr><th class="calDateCol"><strong>Date</strong></th><th class="calDateCommittees"><strong>Meetings</strong></th><th class="calDateTime"><strong>Time</strong></th></tr></table>'
  );
  $("#communityCalList").prepend(
    '<table class="callistheader"><tr><th class="calDateCol"><strong>Date</strong></th><th class="calDateCommittees"><strong>Meetings</strong></th><th class="calDateTime"><strong>Time</strong></th></tr></table>'
  );
  $("#jpaCalList").prepend(
    '<table class="callistheader"><tr><th class="calDateCol"><strong>Date</strong></th><th class="calDateCommittees"><strong>Meetings</strong></th><th class="calDateTime"><strong>Time</strong></th></tr></table>'
  );
});

// On page load if query params, go to event
// run once per page load
// --- add near your other globals ---
var didParamScroll = false;
var pendingParamScroll = !!paramEventId; // block "scroll to top" until we handle deep link

// --- keep your function, just add the bolded lines ---
function queryParamScrollTo() {
  if (didParamScroll) return;
  if (!paramEventId) return;

  var $targets = $(".eventnum-" + paramEventId);
  if (!$targets.length) return; // not in this render

  didParamScroll = true;
  pendingParamScroll = false; // <-- allow top scrolls from now on

  $targets.addClass("yepitsgood");

  var isMobile = window.matchMedia("(max-width: 900px)").matches;
  var $scrollEl = isMobile ? $("html, body") : $("#contentRight");

  var $first = $targets.first();
  var off = $first.offset();
  if (!off || typeof off.top !== "number") return;

  // <-- stop ALL possible queued scrolls cold
  $("html, body, #contentRight").stop(true, true);

  setTimeout(function () {
    if (isMobile) {
      $scrollEl.animate({ scrollTop: off.top }, 1000);
    } else {
      $scrollEl.scrollTo($first, 1000);
    }
  }, 0);

  if (window.history && history.replaceState) {
    var url = new URL(window.location.href);
    url.searchParams.delete("eventid");
    history.replaceState({}, "", url.toString());
  }
}

// Scroll to top on click of next previous
function scrollTopAdaptive() {
  // if we're about to do the deep-link scroll, skip this one
  if (pendingParamScroll) return;

  if (window.matchMedia("(max-width: 900px)").matches) {
    $("html, body").stop(true, true).animate({ scrollTop: 0 }, 250);
  } else {
    $("#contentRight").stop(true, true).animate({ scrollTop: 0 }, 250);
  }
}
