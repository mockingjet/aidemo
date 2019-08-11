let realurl = {
  selectParam: "/send/param",
  deleteParam: "/send/param",
  diagnoseImage: "/predict/send/new",
  getColor: "/send/img/back",
  sendConfirm: "/send/dbset",
  upload: "/add/data/training",
  retrain: "/add/data/retrain"
};

let fakeurl = {
  selectParam: "http://localhost/v6/public/options.php",
  deleteParam: "http://localhost/v6/public/options.php",
  diagnoseImage: "http://localhost/v6/public/input.php",
  getColor: "http://localhost/v6/public/modify.php",
  sendConfirm: "http://localhost/v6/public/confirm.php",
  upload: "http://localhost/v6/public/input.php",
  retrain: "http://localhost/v6/public/input.php"
};

export default (process.env.NODE_ENV == "development" ? fakeurl : realurl);
