<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- si tu as un style global, en CI remplace par base_url() -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" /> -->
    <style>
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: "Inter", system-ui;
  text-align: left;
}

:root{
  --bg:#ffffff;
  --carte:#ffffff;
  --muted:#6b6b6b6b;
  --accent:#0b5be0;
  --radius-md:40px;
  --radius-lg:50px;
  --container-width:100%; /* avant: 2300px */
  --shadow:0 8px 20px rgba(16,24,40,0.08);
  --cardWidth:430px;
}

.container{
  text-align: left;
  background-color: var(--bg);
  width: var(--container-width);
  margin-top: 30px;
  margin-left: 0;
  padding: 20px;
  flex-shrink: 0;
}
.container1{
  text-align: left;
  background-color: var(--bg);
  width: var(--container-width); /* avant: 1850px */
  margin-top: 30px;
  margin-left: 0;
  padding: 20px;
  flex-shrink: 0;
}

.titre{
  background-color: black;
  color: white;
  padding: 10px;
  text-align: left;
  border-radius: 8px;
  width: 980px;
  margin-left: 0;
  margin-bottom: 20px;
  flex-shrink: 0;
}

.iconebar{
  display: flex;
  gap: 120px;
  justify-content: flex-start;
  font-size:32px;
  align-items: center;
  font-weight: bold;
  flex-shrink: 0;
}

.text-wrapper-4 {
  padding: 2px;
  font-family: "Open Sans", Helvetica;
  font-weight: 300;
  color: #58a942;
  font-size: 12px;
  letter-spacing: 0;
  line-height: normal;
  border: 1px solid;
  border-color: #58a942;
  width: fit-content;
  flex-shrink: 0;
}
.annonce{
  margin-top: 1px;
}
.sary {
  width: 140px;
  height: 140px;
  flex-shrink: 0;
}

.icone {
  gap: 2px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 10px;
  flex-shrink: 0;
}

.cartes-container {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  flex-shrink: 0;
}

.container .cartes-container {
  justify-content: flex-start;
}

.container1 .cartes-container {
  justify-content: flex-start;
}

.container .cartes-container .carte1,
.container .cartes-container .carte2,
.container .cartes-container .carte3,
.container .cartes-container .carte4,
.container .cartes-container .carte5,
.container .cartes-container .carte11,
.container .cartes-container .carte13 {
  border-radius: var(--radius-lg);
  padding: 20px;
  margin-top: 20px;
  width: 430px;
  height: 932px;
  box-sizing: border-box;
  position: relative;
  padding-bottom: 50px;
  overflow: hidden;
  border: 1px solid black;
  background-color: var(--carte);
  flex-shrink: 0;
  margin-right: 15px;
}

.container1 .cartes-container .carte1,
.container1 .cartes-container .carte2,
.container1 .cartes-container .carte3,
.container1 .cartes-container .carte4,
.container1 .cartes-container .carte5,
.container1 .cartes-container .carte11,
.container1 .cartes-container .carte13 {
  border-radius: var(--radius-lg);
  padding: 20px;
  margin-top: 20px;
  width: 430px;
  height: 932px;
  box-sizing: border-box;
  position: relative;
  padding-bottom: 50px;
  overflow: hidden;
  border: 1px solid black;
  background-color: var(--carte);
  flex-shrink: 0;
  margin-right: 15px;
}

.sarylava {
  width: 390px;
  height: 400px;
  border-radius: var(--radius-md);
  object-fit: cover;
  flex-shrink: 0;
}
.sarymoyen {
  position: absolute;
  top: 0;
  left: 0;
  width: 390px;
  height: 350px;
  object-fit: cover;
  flex-shrink: 0;
}
.sarymoyen2 {
  margin-top: 100px;
  width: 390px;
  height: 250px;
  object-fit: cover;
  flex-shrink: 0;
}
.accroche {
  margin-top: 25px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 18px;
  font-weight: 500;
  width: 390px;
  gap: 15px;
  flex-shrink: 0;
}
.accroche1 {
  margin-top: 25px;
  display: flex;
  align-items: center;
  font-size: 18px;
  font-weight: 500;
  width: 390px;
  gap: 15px;
  flex-shrink: 0;
}
.texteaccroche {
  text-align: left;
  flex: 1;
  flex-shrink: 0;
  font-size: 16px;
}

.saryoption, .sarytelecharg {
  width: 45px;
  height: 45px;
  flex-shrink: 0;
}

.sarylogo{
  width: 120px;
  display: block;
  margin-top: -20px;
  margin-bottom: 25px;
  flex-shrink: 0;
}

.cardHeader {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 390px;
  margin-bottom: 20px;
  position: relative; /* corrigé: avant il y avait 'position: relative;g' */
  flex-shrink: 0;
}

.searchIconContainer {
  position: absolute;
  top: 0;
  right: 10px;
  flex-shrink: 0;
}

.searchIconTop {
  width: 24px;
  height: 24px;
  flex-shrink: 0;
}

.searchbar {
  display: flex;
  align-items: center;
  background-color: #fff;
  border: 1px solid #dcdcdc;
  border-radius: 28px;
  padding: 12px 16px;
  width: 350px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  margin-top: -30px;
  flex-shrink: 0;
}

.inputsearch {
  border: none;
  outline: none;
  flex: 1;
  font-size: 16px;
  flex-shrink: 0;
}

.inputsearch:focus {
  box-shadow: 0 0 5px var(--accent);
}

.searchicon {
  width: 24px;
  height: 24px;
  flex-shrink: 0;
}

.saryfohy {
  width: 390px;
  height: 220px;
  border-radius: var(--radius-md);
  object-fit: cover;
  margin-top: 15px;
  flex-shrink: 0;
}

.alink {
  color: #1a0dab;
  text-decoration: none;
  font-size: 16px;
  flex-shrink: 0;
  line-height: 1.4;
}

.alink:hover {
  text-decoration: underline;
}

.textcarte {
  margin-top: 15px;
  font-size: 16px;
  color: var(--muted);
  flex-shrink: 0;
}

.paragraphe {
  margin-top: 15px;
  font-size: 15px;
  line-height: 1.6;
  color: #333;
  text-align: justify;
  width: 390px;
  flex-shrink: 0;
}

.cardHeaderYoutube {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 390px;
  margin-bottom: 20px;
  margin-top: 20px;
  flex-shrink: 0;
}
.box .r-sidence-luxe-https {
  position: absolute;
  top: 248px;
  left: 971px;
  width: 227px;
  font-family: "Open Sans", Helvetica;
  font-weight: 400;
  color: #000000;
  font-size: 16px;
  letter-spacing: 0;
  line-height: normal;
  flex-shrink: 0;
}
.text-wrapper-8 {
  font-family: "Open Sans", Helvetica;
  font-weight: 400;
  color: #000000;
  font-size: 14px;
  letter-spacing: 0;
  flex-shrink: 0;
}

.headerIcons {
  display: flex;
  gap: 15px;
  margin-top: -40px;
  flex-shrink: 0;
}

.headerIcon {
  width: 28px;
  height: 28px;
  cursor: pointer;
  flex-shrink: 0;
}

.btn{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 390px;
  margin-top: 20px;
  flex-shrink: 0;
}

.btnBlue {
  background-color: var(--accent);
  color: #fff;
  border: none;
  padding: 14px 24px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  margin-top: 15px;
  transition: background-color 0.3s ease;
  width: 390px;
  flex-shrink: 0;
}

.btnBlue:hover {
  background-color: #0846b3;
}

.cardHeaderGmail {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 390px;
  margin-bottom: 20px;
  flex-shrink: 0;
}

.sarylogoGmail {
  width: 120px;
  display: block;
  flex-shrink: 0;
}

.searchbarGmail {
  display: flex;
  align-items: center;
  justify-content: end;
  border: 1px solid #dcdcdc;
  border-radius: 28px;
  padding: 10px;
  width: 100px;
  height: 25px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  flex-shrink: 0;
}

.accroche4{
  margin-top: -50px;
  display: flex;
  align-items: center;
  font-size: 18px;
  font-weight: 500;
  width: 390px;
  flex-shrink: 0;
  gap: 10px;
}

.menubar {
  display: flex;
  justify-content: space-around;
  align-items: center;
  width: 390px;
  margin-top: auto;
  padding: 15px 0;
  position: absolute;
  bottom: 15px;
  left: 20px;
  right: 20px;
  border-bottom-left-radius: var(--radius-lg);
  border-bottom-right-radius: var(--radius-lg);
  flex-shrink: 0;
}

.menu-icon {
  width: 24px;
  height: 24px;
  object-fit: contain;
  flex-shrink: 0;
}

.carte11 {
  padding: 0;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.card-image-container {
  position: relative;
  width: 390px;
  height: 350px;
  overflow: hidden;
  flex-shrink: 0;
}

.card-image-container .sarymoyen {
  position: relative;
  width: 100%;
  height: 100%;
  border-radius: var(--radius-lg) var(--radius-lg) 0 0;
}

.sponsor-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  background-color: rgba(255, 255, 255, 0.9);
  color: #333;
  padding: 6px 12px;
  border-radius: 16px;
  font-size: 13px;
  font-weight: 500;
  border: 1px solid #e0e0e0;
  z-index: 10;
  flex-shrink: 0;
}

.search-container {
  position: absolute;
  top: 60px;
  left: 15px;
  right: 15px;
  z-index: 10;
  flex-shrink: 0;
}

.search-field {
  background-color: rgba(255, 255, 255, 0.95);
  border: 1px solid #dadce0;
  border-radius: 24px;
  padding: 14px 20px;
  font-size: 16px;
  color: #3c4043;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  width: 360px;
  box-sizing: border-box;
  flex-shrink: 0;
}

.search-text {
  color: #5f6368;
  font-size: 15px;
  flex-shrink: 0;
}

.card-content {
  padding: 20px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  width: 390px;
  flex-shrink: 0;
}

.card-title {
  font-size: 20px;
  font-weight: 600;
  margin: 0 0 12px 0;
  color: #333;
  width: 350px;
  flex-shrink: 0;
}

.card-description {
  font-size: 16px;
  color: #666;
  margin: 0 0 20px 0;
  line-height: 1.5;
  width: 350px;
  flex-shrink: 0;
}

.rating-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  width: 350px;
  flex-shrink: 0;
}

.stars {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
}

.star {
  color: #FFD700;
  font-size: 20px;
  flex-shrink: 0;
}

.rating-text {
  font-size: 16px;
  color: #666;
  margin-left: 6px;
  flex-shrink: 0;
}

.status {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  flex-shrink: 0;
}

.open {
  font-size: 16px;
  color: #0a8a08;
  font-weight: 500;
  flex-shrink: 0;
}

.closing {
  font-size: 14px;
  color: #666;
  flex-shrink: 0;
}

.small-images {
  display: flex;
  justify-content: space-between;
  margin: 15px 0;
  width: 350px;
  flex-shrink: 0;
}

.small-icon {
  width: 100px;
  height: 100px;
  border-radius: 12px;
  object-fit: cover;
  border: 1px solid #e0e0e0;
  flex-shrink: 0;
}

.action-links {
  display: flex;
  justify-content: space-between;
  width: 350px;
  margin-top: 10px;
  flex-shrink: 0;
}

.action-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #1a73e8;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  gap: 6px;
  flex-shrink: 0;
}

.action-link:hover {
  text-decoration: underline;
}

.link-icon {
  width: 28px;
  height: 28px;
  object-fit: contain;
  flex-shrink: 0;
}

.action-buttons {
  display: flex;
  gap: 12px;
  margin: 15px 0;
  width: 350px;
  flex-shrink: 0;
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  transition: background-color 0.2s;
  flex: 1;
  justify-content: center;
  flex-shrink: 0;
}

.action-btn:hover {
  background-color: #f5f5f5;
}

.btn-icon {
  width: 18px;
  height: 18px;
  object-fit: contain;
  flex-shrink: 0;
}

.bottom-links {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: auto;
  padding-top: 15px;
  border-top: 1px solid #f0f0f0;
  width: 350px;
  flex-shrink: 0;
}

.bottom-link {
  color: #1a73e8;
  text-decoration: none;
  font-size: 15px;
  padding: 6px 0;
  flex-shrink: 0;
}

.bottom-link:hover {
  text-decoration: underline;
}

.carte13 {
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.image-container {
  position: relative;
  width: 390px;
  height: 400px;
  overflow: hidden;
  margin-bottom: 20px;
  flex-shrink: 0;
}

.image-container .sarylava {
  position: relative;
  width: 100%;
  height: 100%;
  border-radius: var(--radius-md);
  object-fit: cover;
}

.blue-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(11, 91, 224, 0.7) 0%, rgba(8, 70, 179, 0.8) 100%);
  border-radius: var(--radius-md);
  z-index: 1;
  opacity: 80%;
  flex-shrink: 0;
}

.overlay-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 22px;
  font-weight: 600;
  text-align: center;
  line-height: 1.5;
  z-index: 2;
  width: 350px;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  flex-shrink: 0;
}

/* --- RÈGLES SPÉCIALES IMPRESSION / WKHTMLTOPDF --- */
@media print {
  html, body {
    margin: 0;
    padding: 0;
    height: auto;
  }

  .container,
  .container1 {
    margin: 0 !important;
    padding: 10px 0 0 0 !important;
    width: 100% !important;
  }

  /* si tu veux forcer container1 sur une nouvelle "page" logique pour wkhtmltopdf */
  .container1 {
    page-break-before: always;
    break-before: page;
  }

  /* éviter les coupures de cartes */
  .cartes-container,
  .carte1,
  .carte2,
  .carte3,
  .carte4,
  .carte5,
  .carte11,
  .carte13 {
    break-inside: avoid;
    page-break-inside: avoid;
  }
}
    </style>
    <title>PMAX</title>
  </head>
  <body>
   <div class="titre">
      <h3>PMAX</h3>
    </div>
    <div class="titre">
      <h3>PMAX</h3>
    </div>
    <div class="container">
      <div class="iconebar">
        <div class="icone">
          <img src="icone/display-icon-48-4.png" alt="Display" class="sary" />
          <span>Display</span>
        </div>
        <div class="icone">
          <img src="icone/youtube.png" alt="youtube" class="sary" />
          <span>Youtube</span>
        </div>
        <div class="icone">
          <img src="icone/google.png" alt="google" class="sary" />
          <span>Google</span>
        </div>
        <div class="icone">
          <img src="icone/gmail.png" alt="gmail" class="sary" />
          <span>Gmail</span>
        </div>
        <div class="icone">
          <img src="icone/galerie.png" alt="Discovery" class="sary" />
          <span>Discovery</span>
        </div>
      </div>
      <div class="cartes-container">
        <div class="carte1">
          <img src="icone/mask-group.png" alt="carte1" class="sarylava" />
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <div class="texteaccroche">
              <span class="textaccroche">Chalet de luxe disponibles</span>
            </div>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <span class="textcarte">Découvrez les nouveautés de PMAX</span>
           <p class="paragraphe">
            Location de Chalets de Luxe et d’Appartements à Serre Chevalier. Réservez dès Maintenant
          </p>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte2">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
            <div class="searchbar">
              <input
                type="text"
                placeholder="Chalet de Luxe Disponibles"
                class="inputsearch"
              />
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="saryfohy" />
          <p>Sponsorisé</p>
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <p class="paragraphe">
            Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
          </p>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte3">
          <div class="cardHeaderYoutube">
            <img
              src="icone/you-tube-logo-without-background-c21e.png"
              alt="Youtube"
              class="sarylogo"
            />
            <div class="headerIcons">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="headerIcon"
              />
              <img
                src="icone/notification.png"
                alt="Notifications"
                class="headerIcon"
              />
              <img src="icone/menu.png" alt="Menu" class="headerIcon" />
            </div>
          </div>
          <img src="icone/mask-group-5.png" alt="carte3" class="sarylava" />
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <div class="texteaccroche">
              <span class="textaccroche">Chalet de luxe disponibles</span>
            </div>
            <img src="icone/ellipse-9-1.png" alt="option" class="saryoption" />
          </div>
          <span class="textcarte">Découvrez les nouveautés de PMAX</span>
          <div class="btn">
            <button class="btnBlue">Book now</button>
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte4">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
            <div class="searchIconContainer">
              <img
                src="icone/ellipse-9-2.png"
                alt="Search"
                class="searchIconTop"
              />
            </div>
            <div class="searchbar">
              <input
                type="text"
                placeholder="Chalet de Luxe Disponibles"
                class="inputsearch"
              />
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="accroche1">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="saryfohy" />
          <p class="paragraphe">
            Location de Chalets de Luxe et d’Appartements à Serre Chevalier. Réservez dès Maintenant
          </p>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte5">
          <div class="cardHeaderGmail">
            <img src="icone/R.png" alt="Gmail" class="sarylogoGmail" />
            <div class="searchbarGmail">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
           <div class="annonce">
            <div class="text-wrapper-4">ANNONCE</div>
          </div>
          <div class="accroche1">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="saryfohy" />
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>

        <div class="carte1">
          <img src="icone/mask-group.png" alt="carte1" class="sarylava" />
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <div class="texteaccroche">
              <span class="textaccroche">Notre Service de Conciergerie s’occupe de Tout</span>
            </div>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <span class="textcarte">Découvrez les nouveautés de PMAX</span>
          <div class="btn">
            <button class="btnBlue">Book now</button>
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>

        <div class="carte2">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
            <div class="searchbar">
              <input
                type="text"
                placeholder="Chalet de Luxe Disponibles"
                class="inputsearch"
              />
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <img src="icone/mask-group-3.png" alt="option" class="saryoption" />
          </div>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <p class="paragraphe">
            Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
          </p>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <br />
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte3">
          <div class="cardHeaderYoutube">
            <img
              src="icone/you-tube-logo-without-background-c21e.png"
              alt="Youtube"
              class="sarylogo"
            />
            <div class="headerIcons">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="headerIcon"
              />
              <img
                src="icone/notification.png"
                alt="Notifications"
                class="headerIcon"
              />
              <img src="icone/menu.png" alt="Menu" class="headerIcon" />
            </div>
          </div>
          <img src="icone/mask-group.png" alt="carte3" class="saryfohy" />
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <div class="texteaccroche">
              <span class="textaccroche">Chalet de luxe disponibles</span>
            </div>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <span class="textcarte">Découvrez les nouveautés de PMAX</span>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte4">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
          </div>
          <div class="accroche4">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
           <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="sarylava" />
          <p class="paragraphe">
           Notre Service de Conciergerie s’occupe de Tout. Vos Vacances Méritent d'être Inoubliables
          </p>
          <div class="btn">
            <button class="btnBlue">Book now</button>
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        <div class="carte5">
          <div class="cardHeaderGmail">
            <img src="icone/R.png" alt="Gmail" class="sarylogoGmail" />
            <div class="searchbarGmail">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="accroche1">
            <div class="annonce">
            <div class="text-wrapper-4">ANNONCE</div>
          </div>
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
          </div>
          <div class="accroche">
            <img src="icone/image-177.png" alt="avatar" class="sarytelecharg" />
            <div class="texteaccroche">
              <span class="paragraphe">Chalet de luxe disponibles</span>
            </div>
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
      </div>
    </div>
    <br />
    <br />

    <div class="container1">
      <div class="iconebar">
        <div class="icone">
          <img src="icone/image-243.png" alt="Locale" class="sary" />
          <span>Locale</span>
        </div>
        <div class="icone">
          <img src="icone/display-icon-48-4.png" alt="Display" class="sary" />
          <span>Display</span>
        </div>
        <div class="icone">
          <img src="icone/google.png" alt="google" class="sary" />
          <span>Search</span>
        </div>
        <div class="icone">
          <img src="icone/gmail.png" alt="gmail" class="sary" />
          <span>Gmail</span>
        </div>
        
      </div>
      <div class="cartes-container">
        <div class="carte11">
          <div class="card-image-container">
            <div class="search-container">
              <div class="search-field">
                <span class="search-text">Chalet de luxe disponibles</span>
              <!-- <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              /> -->
              </div>
            </div>
            <img
              src="icone/image-186.png"
              alt="Chalet de luxe"
              class="sarymoyen"
            />
            <div class="sponsor-badge">Sponsorisé</div>
          </div>

          <div class="card-content">
            <h3 class="card-title">Chalet de luxe disponibless</h3>
            <p class="card-description">
              Location de Chalets de Luxe et d'Appartements à Serre Chevalier.
            </p>
            <div class="rating-container">
              <div class="stars">
                <span class="star">★</span>
                <span class="rating-text">5 (35)</span>
              </div>
              <div class="status">
                <span class="open">Ouvert</span>
                <span class="closing">Ferme à 20h11</span>
              </div>
            </div>

            <div class="small-images">
              <img
                src="icone/mask-group.png"
                alt="Site web"
                class="small-icon"
              />
              <img
                src="icone/mask-group.png"
                alt="Itinéraire"
                class="small-icon"
              />
              <img src="icone/mask-group.png" alt="Appel" class="small-icon" />
            </div>

            <div class="action-links">
              <a href="#" class="action-link">
                <img src="icone/vector-47.svg" alt="Site" class="link-icon" />
                Site Internet
              </a>
              <a href="#" class="action-link">
                <img
                  src="icone/vector-48.svg"
                  alt="Itinéraire"
                  class="link-icon"
                />
                Itinéraire
              </a>
              <a href="#" class="action-link">
                <img src="icone/vector-49.svg" alt="Appel" class="link-icon" />
                Appel
              </a>
            </div>
          </div>
        </div>
        
        <div class="carte1">
          <img src="icone/mask-group.png" alt="carte1" class="sarylava" />
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <div class="texteaccroche">
              <span class="textaccroche">Chalet de luxe disponibles</span>
            </div>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <p class="paragraphe">
            Location de Chalets de Luxe et d’Appartements à Serre Chevalier. Réservez dès Maintenant
          </p>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>

        <div class="carte2">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
            <div class="searchbar">
              <input
                type="text"
                placeholder="Chalet de luxe disponibles"
                class="inputsearch"
              />
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="saryfohy" />
          <p>Sponsorisé</p>
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <p class="paragraphe">
            Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
          </p>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        
       
        <div class="carte5">
          <div class="cardHeaderGmail">
            <img src="icone/R.png" alt="Gmail" class="sarylogoGmail" />
            <div class="searchbarGmail">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="annonce">
            <div class="text-wrapper-4">ANNONCE</div>
          </div>
          <div class="accroche1">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <!-- <div class="texteaccroche">
              <span class="textaccroche">Résidence luxe</span>
            </div> -->
          </div>
          <img src="icone/mask-group.png" alt="carte2" class="saryfohy" />
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>

       <div class="carte11">
          <div class="card-image-container">
            <div class="search-container">
              <div class="search-field">
                <span class="search-text">Chalet de luxe disponibles</span>
              </div>
            </div>
            <img
              src="icone/mask-group.png"
              alt="Chalet de luxe"
              class="sarymoyen2"
            />
            <!-- <div class="sponsor-badge">Sponsorisé</div> -->
          </div>
          <div class="card-content">
            <h3 class="card-title">Location de Chalets de Luxe et d’Appartements à Serre Chevalier.</h3>
           
            <div class="rating-container">
              <div class="stars">
                <span class="star">★</span>
                <span class="rating-text">5 (35)</span>
              </div>
              <div class="status">
                <span class="open">Ouvert</span>
                <span class="closing">Ferme à 20h11</span>
              </div>
            </div>

            <div class="small-images">
              <img
                src="icone/mask-group.png"
                alt="Site web"
                class="small-icon"
              />
              <img
                src="icone/mask-group.png"
                alt="Itinéraire"
                class="small-icon"
              />
              <img src="icone/mask-group.png" alt="Appel" class="small-icon" />
            </div>

            <div class="action-buttons">
      <button class="action-btn">
        <img src="icone/vector-48.svg" alt="Itinéraire" class="btn-icon" />
        Itinéraire
      </button>
      <button class="action-btn">
        <img src="icone/vector-49.svg" alt="Appeler" class="btn-icon" />
        Appeler
      </button>
    </div>

    <div class="bottom-links">
      <a href="#" class="bottom-link">Location de Chalets</a>
      <a href="#" class="bottom-link">Visiter le site Internet</a>
    </div>
          </div>
        </div>

        <div class="carte13">
  <div class="image-container">
    <img src="icone/mask-group.png" alt="carte1" class="sarylava" />
    <div class="blue-overlay"></div>
    <div class="overlay-text">Large choix de chalets. Capacité jusqu'à 24 convives</div>
  </div>
  <div class="accroche">
    <img
      src="icone/image-177.png"
      alt="download"
      class="sarytelecharg"
    />
    <div class="texteaccroche">
      <span class="textaccroche">Notre service de concièrgerie s'occupe de tout.</span>
    </div>
    <img src="icone/menu.png" alt="option" class="saryoption" />
  </div>
  <div class="btn">
    <button class="btnBlue">Book now</button>
  </div>
  <div class="menubar">
    <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
    <img src="icone/google.png" alt="icon3" class="menu-icon" />
    <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
  </div>
</div>

        <div class="carte2">
          <div class="cardHeader">
            <img
              src="icone/google-logo-png-b472.png"
              alt="Google"
              class="sarylogo"
            />
            <div class="searchbar">
              <input
                type="text"
                placeholder="Chalet de Luxe Disponibles"
                class="inputsearch"
              />
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="accroche">
            <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            />
             <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <!-- <div class="texteaccroche">
              <span class="textaccroche">Résidence luxe</span>
            </div> -->
            <img src="icone/menu.png" alt="option" class="saryoption" />
          </div>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <p class="paragraphe">
            Sélection des plus beaux chalets de luxe à Serre Chevalier, avec service à domicile et organisation d'activités à la carte et sur mesure. Découvrez Notre Sélection De Chalets Uniques, Idéalement...
          </p>
          <p class="paragraphe">
            20 rue les petits pos 772012 Le valnceces
          </p>
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <br />
          <div class="textealink">
            <a href="#" class="alink"
              >Location de Chalets de Luxe & Prestige à Serre Chevalier</a
            >
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
        
        <div class="carte5">
          <div class="cardHeaderGmail">
            <img src="icone/R.png" alt="Gmail" class="sarylogoGmail" />
            <div class="searchbarGmail">
              <img
                src="icone/vector-43.svg"
                alt="Search"
                class="searchicon"
              />
            </div>
          </div>
          <div class="accroche1">
            <!-- <img
              src="icone/image-177.png"
              alt="download"
              class="sarytelecharg"
            /> -->
            <div class="annonce">
            <div class="text-wrapper-4">ANNONCE</div>
          </div>
            <p class="r-sidence-luxe-https">
              <span class="span">Résidence Luxe<br /></span>
              <span class="text-wrapper-8">https://www.residence-luxe.com</span>
            </p>
            <!-- <div class="texteaccroche">
              <span class="textaccroche">Résidence luxe</span>

            </div> -->
          </div>
          <div class="accroche">
            <img src="icone/image-177.png" alt="avatar" class="sarytelecharg" />
            <div class="texteaccroche">
              <span class="paragraphe">Location de Chalets de Luxe & Prestige à Serre Chevalier</span>
            </div>
          </div>
          <div class="menubar">
            <img src="icone/youtube.png" alt="icon2" class="menu-icon" />
            <img src="icone/google.png" alt="icon3" class="menu-icon" />
            <img src="icone/gmail.png" alt="icon4" class="menu-icon" />
          </div>
        </div>
      </div>
    </div></body>
</html>
