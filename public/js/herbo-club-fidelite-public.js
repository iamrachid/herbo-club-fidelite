(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  // Show the first tab and hide the rest

  $("#f_verify").hide();
  $("#f_iframe").hide();

  $("#f_like").click(function () {
    const fan_count_url =
      "https://graph.facebook.com/v11.0/1875203236025758/?access_token=EAAHl1plOZAyMBAAHbIG1XmsXVrghdiojyzucjQBcz8wMjcQIjHXxoluDRZA5wD6bbNEh2ZBJaTTEuqLuvyb4JRQSqvVoZBrZBFHZC5nlsujgsL9lWr8U7KyRZB5C4ecbkUovdJC4YZBBZCsi3jGlMZBX04LJBedh0nkRBmZA4yyAZC2HcPbdWbxBlZCJ8&debug=all&fields=fan_count&format=json&method=get&pretty=0&suppress_http_code=1&transport=cors";
    $.get(fan_count_url, function (response) {
      const fan_count = response.fan_count;
      console.log(fan_count);

      window.open("https://facebook.com/themousaid", "Like our page");
      $("#f_verify").show();
      $("#f_like").hide();
      $("#f_iframe").show();
      $("#f_verify").click(function () {
        $.get(fan_count_url, function (response) {
          console.log(response.fan_count);
          if (fan_count < response.fan_count) {
            const data = {
              action: "update_points",
              nonce: herbo_club_fidelite.nonce,
              earned: 50,
              p_action: "f_like",
            };
            $.post(herbo_club_fidelite.ajax_url, data, function (response) {
              console.log(response);
            });
            $(".tab-content").hide();
          }
        });
      });
    });
  });

  // Modal
  var modal = $("#modal-one")[0];
  console.log(modal);

  var exits = $(".modal-exit");
  for (var i = 0, exit = exits[i]; i < exits.length; i++, exit = exits[i]) {
    exit.onclick = () => {
      modal.classList.remove("open");
    };
  }

  const f_like = (button) => {
    const fan_count_url =
      "https://graph.facebook.com/v11.0/1875203236025758/?access_token=EAAHl1plOZAyMBAAHbIG1XmsXVrghdiojyzucjQBcz8wMjcQIjHXxoluDRZA5wD6bbNEh2ZBJaTTEuqLuvyb4JRQSqvVoZBrZBFHZC5nlsujgsL9lWr8U7KyRZB5C4ecbkUovdJC4YZBBZCsi3jGlMZBX04LJBedh0nkRBmZA4yyAZC2HcPbdWbxBlZCJ8&debug=all&fields=fan_count&format=json&method=get&pretty=0&suppress_http_code=1&transport=cors";
    $.get(fan_count_url, function (response) {
      const fan_count = response.fan_count;
      // log
      console.log(fan_count);

      window.open("https://facebook.com/themousaid", "Like our page");
      button.onclick = () => {
        $.get(fan_count_url, function (response) {
          // log
          console.log(response.fan_count);
          if (fan_count < response.fan_count) {
            const data = {
              action: "update_points",
              nonce: herbo_club_fidelite.nonce,
              earned: 50,
              p_action: "f_like",
            };
            $.post(herbo_club_fidelite.ajax_url, data, function (response) {
              // log
              console.log(response);
              location.reload();
            });
          }
        });
      };
    });
  };

  const i_follow = (button) => {
    console.log("hello");
    const settings = {
      crossDomain: true,
      url: "https://instagram40.p.rapidapi.com/account-info?username=herboristerie.principale&wrap=0",
      method: "GET",
      headers: {
        "x-rapidapi-host": "instagram40.p.rapidapi.com",
        "x-rapidapi-key": "ad8b9839cfmsh2111b4d55630b0ap1b0dc6jsn68466adfc7ce",
      },
    };
    $.ajax(settings).done(function (response) {
      console.log("world");
      const fan_count = response.edge_followed_by.count;
      // log
      console.log(fan_count);

      window.open(
        "https://www.instagram.com/herboristerie.principale/",
        "Follow our ig"
      );

      button.onclick = () => {
        $.ajax(settings).done(function (response) {
          // log
          console.log(response.edge_followed_by.count);
          if (fan_count < response.edge_followed_by.count) {
            const data = {
              action: "update_points",
              nonce: herbo_club_fidelite.nonce,
              earned: 100,
              p_action: "i_follow",
            };
            $.post(herbo_club_fidelite.ajax_url, data, function (response) {
              // log
              console.log(response);
              location.reload();
            });
          }
        });
      };
    });
  };

  const f_share = (button) => {
    const f_share_url =
      "https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.herboristerie-principale.ma";
    window.open(f_share_url);
    setTimeout(() => {
      const data = {
        action: "update_points",
        nonce: herbo_club_fidelite.nonce,
        earned: 100,
        p_action: "f_share",
      };
      $.post(herbo_club_fidelite.ajax_url, data, function (response) {
        // log
        console.log(response);
        location.reload();
      });
    }, 10000);
  };

  const referral = (button) => {
    button.onclick = () => {
      console.log($("#ref-copy"));
      const link = $("#ref-copy").val();
      navigator.clipboard.writeText(link).then(() => {
        button.innerHTML = "Copié";
        button.classList.add("copied");
        button.classList.remove("copy");
        setTimeout(() => {
          button.innerHTML = "Activer";

          button.classList.remove("copied");
        }, 3000);
      });
    };
  };

  // actions
  let buttons = document.querySelectorAll("[data-action]");
  buttons.forEach((button) => {
    button.onclick = () => {
      let action = button.dataset.action;
      console.log("clicked");
      switch (action) {
        case "f_like":
          button.innerHTML = "verifier";
          f_like(button);
          break;
        case "i_follow":
          button.innerHTML = "verifier";
          i_follow(button);
          break;
        case "f_share":
          f_share(button);
          break;
        case "referral":
          button.innerHTML = "copier";
          button.classList.add("copy");
          referral(button);
          break;
      }
    };
  });
})(jQuery);
