earth

var earth;
function initialize() {
  earth = new WE.map('earth_div');
  earth.setView([48.801408, 2.130122], 2);
  WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution: '© OpenStreetMap contributors'
  }).addTo(earth);

  //Start a simple rotation animation
  var before = null;
  requestAnimationFrame(function animate(now) {
      var c = earth.getPosition();
      var elapsed = before? now - before: 0;
      before = now;
      earth.setCenter([c[0], c[1] + 0.1*(elapsed/30)]);
      requestAnimationFrame(animate);
  });
  var marker = WE.marker([39.399872, -8.224454]).addTo(earth);
  marker.bindPopup("<b>Bem-vindo a  </b><a href='/pt'>Portugal</a>", {maxWidth: 150, closeButton: true})//.openPopup();

  // var marker2 = WE.marker([30.058056, 31.228889]).addTo(earth);
  // marker2.bindPopup("<b>Cairo</b><br>Yay, you found me!", {maxWidth: 120, closeButton: true});

  var marker3 = WE.marker([48.801408, 2.130122]).addTo(earth);
  marker3.bindPopup("<b>Bienvenue en  </b><a href='/fr'>France</a>", {maxWidth: 120, closeButton: true});

  var marker4 = WE.marker([20.595164, 78.963606]).addTo(earth);
  marker4.bindPopup("<b>Welcome to  </b><a href='/ind'>India</a>", {maxWidth: 120, closeButton: true});

  var marker5 = WE.marker([19.432608, -99.133208]).addTo(earth);
  marker5.bindPopup("<b>Bienvenido en  </b><a href='/mx'>Mexico</a>", {maxWidth: 120, closeButton: true});

  var markerCustom = WE.marker([50, -9], '/img/logo-webglearth-white-100.png', 100, 24).addTo(earth);

  
}





  



