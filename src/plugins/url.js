let realurl = {
  selectParam: "/send/view2param",
  deleteParam: "/send/view2param",
  diagnoseImage: "/predict/send/bigimage",
  getProgress: "/send/progress/back",
  getColor: "/send/img/back",
  sendConfirm: "/send/dbset",
  upload: "/add/data/training",
  view2upload: "/add/data/view2training",
  retrain: "/add/data/retrain",
  view2retrain: "/add/data/view2retrain",
  modifyImage: "/modify/send/position",
  diagnoseByGland: "/send/coord/diagnose",
  hasImageConfig: "has/img/config"
};

let fakeurl = {
  selectParam: "http://localhost/v7/public/options.php",
  deleteParam: "http://localhost/v7/public/options.php",
  diagnoseImage: "http://localhost/v7/public/input.php",
  getProgress: "http://localhost/v7/public/progress.php",
  getColor: "http://localhost/v7/public/modify.php",
  sendConfirm: "http://localhost/v7/public/confirm.php",
  upload: "http://localhost/v7/public/input.php",
  view2upload: "http://localhost/v7/public/input.php",
  retrain: "http://localhost/v7/public/input.php",
  modifyImage: "http://localhost/v7/public/input.php",
  view2retrain: "http://localhost/v7/public/input.php",
  diagnoseByGland: "http://localhost/v7/public/modify.php",
  hasImageConfig: "http://localhost/v7/public/input.php"
};

export default (process.env.NODE_ENV == "development" ? fakeurl : realurl);
