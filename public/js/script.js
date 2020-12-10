<<<<<<< HEAD
earth

var earth;
function initialize() {
  earth = new WE.map('earth_div');
  earth.setView([48.801408, 2.130122], 2);
  WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution: '© OpenStreetMap contributors'
  }).addTo(earth);

  // Start a simple rotation animation
  var before = null;
  requestAnimationFrame(function animate(now) {
      var c = earth.getPosition();
      var elapsed = before? now - before: 0;
      before = now;
      earth.setCenter([c[0], c[1] + 0.1*(elapsed/30)]);
      requestAnimationFrame(animate);
  });
  var marker = WE.marker([41.3833, 2.1833]).addTo(earth);
  marker.bindPopup("<b>Voyagaez à </b><a href='https://fr.wikipedia.org/wiki/Barcelone'>Barcelone</a><span style='font-size:10px;color:#999'></span>", {maxWidth: 150, closeButton: true})//.openPopup();

  var marker2 = WE.marker([30.058056, 31.228889]).addTo(earth);
  marker2.bindPopup("<b>Cairo</b><br>Yay, you found me!", {maxWidth: 120, closeButton: true});

  var marker3 = WE.marker([48.801408, 2.130122]).addTo(earth);
  marker3.bindPopup("<b>Versailles</b><br>Meilleure Ville du monde!", {maxWidth: 120, closeButton: false});

  var markerCustom = WE.marker([50, -9], '/img/logo-webglearth-white-100.png', 100, 24).addTo(earth);


}





  


=======

// earth

// var earth;
// function initialize() {
//   earth = new WE.map('earth_div');
//   earth.setView([48.801408, 2.130122], 1);
//   WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
//     attribution: '© OpenStreetMap contributors'
//   }).addTo(earth);

//   // Start a simple rotation animation
//   var before = null;
//   requestAnimationFrame(function animate(now) {
//       var c = earth.getPosition();
//       var elapsed = before? now - before: 0;
//       before = now;
//       earth.setCenter([c[0], c[1] + 0.1*(elapsed/30)]);
//       requestAnimationFrame(animate);
//   });
// }
>>>>>>> 1132605d041f1778556df6986a8d7fe81ff9a916

