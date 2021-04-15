var url_root = "";

var geolocation = null;

if (window.navigator && window.navigator.geolocation) {
  geolocation = window.navigator.geolocation;
}

if (geolocation) {
  geolocation.getCurrentPosition(function (position) {
    var position = position;
    $.ajax({
      type: "POST",
      url: url_root + "controleur.php",
      dataType: "json",
      data: { contenu: position },
      success: function (oRep) {
        console.log(oRep);
      }, // fin success
    }); // ajax POST paragraphe
  });
}
