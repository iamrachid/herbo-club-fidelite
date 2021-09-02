class InstagramVerification {
  constructor($, businessUrl, userurl) {
    this.businessUrl = businessUrl;
    this.userurl = userurl;
    this.$ = $;
  }

  getBusinessFollowers() {
    const businessGraphlqlObject = getGraphlqlObject(businessUrl);

    return businessGraphlqlObject;
  }

  getGraphlqlObject(url) {
    var regex = /instagram.com\/([^ /]+)/g;
    var username = regex.exec(url)[1];

    // let settings = {
    //   async: true,
    //   crossDomain: true,
    //   url:
    //     "https://instagram40.p.rapidapi.com/account-info?username=" + username,
    //   method: "GET",
    //   headers: {
    //     "x-rapidapi-key": "ad8b9839cfmsh2111b4d55630b0ap1b0dc6jsn68466adfc7ce",
    //     "x-rapidapi-host": "instagram40.p.rapidapi.com",
    //   },
    // };
    // let id;

    // $.ajax(settings).done(function (response) {
    //   console.log(response.id);
    //   id = response.id;
    // });

    let id = 7271027;

    settings.url = "https://instagram40.p.rapidapi.com/followers?userid=" + id;

    $.ajax(settings).done(function (response) {
      console.log(response.users);
      users = response.users;
    });
    users.forEach((user) => {
      if (user.username === username) {
        return true;
      }
    });
    return false;
  }

  getUserId() {
    const userGraphlqlObject = getGraphlqlObject(userUrl);
    return;
  }
}
