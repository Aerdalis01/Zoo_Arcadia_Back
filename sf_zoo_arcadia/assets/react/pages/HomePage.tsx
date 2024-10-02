
import React from 'react';
import Carousel from '../controllers/components/carousel';


const HomePage = () => {
  const carouselItems = [
    {
      id: 'slide1',
      imgSrc: '/uploads/images/carousel/CerfBlancMobil.webp',
      altText: 'Cerf blanc dans la forêt',
      title: 'Bienvenue au Zoo Arcadia',
      description: 'Un zoo familial soucieux des animaux et de leur environnement...',
      className: 'carousel-img--accueil',
    },
    {
      id: 'slide2',
      imgSrc: '/uploads/images/carousel/Marais-sm.webp',
      altText: 'Des flamants roses dans une zone humide',
      title: 'Le marais',
      description: 'Notre zone humide et boisé permet d’abriter de nombreuses espèces...',
      className: 'carousel-img--marais',
    },
    {
      id: 'slide3',
      imgSrc: '/uploads/images/carousel/Savane-sm.webp',
      altText: 'Image de la savanne',
      title: 'La savanne',
      description: 'Découvrez un univers majestueux où se côtoient girafes, gnous et zèbres sur un terrain de 2 hectares',
      className: 'carousel-img--savane',
    },
    {
      id: 'slide4',
      imgSrc: '/uploads/images/carousel/Jungle-sm.webp',
      altText: 'Image d\'une jungle',
      title: 'La jungle',
      description: 'Dans la luxuriante jungle d’Arcadia, vous pourrez découvrir nos chimpanzés, ouistitis ainsi que nombres d\'animaux étonnants et d\'oiseaux rares.',
      className: 'carousel-img--jungle',
    },
    
  ];
  // return(<>Bienvenue au zoo</>)  
  return (
    <>
      <section id="accueil">
      <Carousel items={carouselItems} />
      </section>
      {/* Début section services */}
      <section className="services">
        <div className="content-greenSvg w-100">
          <img className="img-fluid w-100" src="/uploads/images/svgDeco/RecOvalVert.svg" alt="Forme géométrique de couleur verte"/>
        </div>
        <div className="services-svg w-100 py-md-2 py-lg-3 py-xl-4 py-xxl-5">
          <div className="services-title text-center py-2">
            <h1 className="text-white">Services</h1>
            <h6 className="text-white">Retrouvez toutes nos offres</h6>
          </div>
          <div className="content-orangeSvg">
            <img className="svg-rectangle img-fluid w-100" src="/uploads/images/svgDeco/RecOrLg.svg" alt="Rectangle Orange"/>
            <img className="svg-ellipse  w-100" src="/uploads/images/svgDeco/demiElOrmob.svg" alt="ellipse Orange"/>
          </div>
        </div>
        {/* Services cards */}
        <div className="container-fluid service-container px-md-4 px-md-5 py-1">
          <div className="row d-flex align-items-center justify-content-center  g-0 ">
            <div className="card-group px-sm-2 px-md-3 px-lg-4 px-xl-5">
              <div className="card accueil-services--restauration mb-3" data-section="restaurations">
                <div className="row w-100 text-center d-flex  justify-content-center g-0">
                  <div className="img-service col-5 col-sm-12 p-2 p-md-3 p-lg-4 p-xl-5">
                    <img src="/uploads/images/services/Resto.webp" className="img-fluid img-resto rounded-5"
                      alt="Image d'une famille mangeant sur une table de pic-nique dans un zoo"/>
                  </div>
                  {/* Card Restauration */}
                  <div className="col-7 col-sm-12 d-flex justify-content-center p-2">
                    <div className="card-body bg-warning rounded-5 p-1">
                      <h4 className="card-title">Restauration</h4>
                      <p className="card-text">Venez découvrir notre restaurant panoramique et nos autres offres de restaurations.
                      </p>
                    </div>
                  </div>
                  <button className="restau-btn col-3 col-sm-5 rounded-5 mt-2 fs-5" type="button">Voir plus
                  </button>
                </div>
              </div>
              {/* Card Visites Guidées */}
              <div className="card accueil-services--visite mb-3" data-section="visite">
                <div className="row w-100 text-center d-flex  justify-content-center g-0">
                  <div className="img-service col-5 col-sm-12 p-2 p-md-3 p-lg-4 p-xl-5">
                    <img src="/uploads/images/services/VisiteGuidee.webp" className="img-fluid rounded-5"
                      alt="Image d'une visite guidée dans un zo, devant l'enclos d'un gorille"/>
                  </div>
                  <div className="col-7 col-sm-12 d-flex justify-content-center p-2">
                    <div className="card-body bg-warning rounded-5 p-1">
                      <h4 className="card-title">Visites guidées</h4>
                      <p className="card-text">Profitez de notre visite guidée pour en apprendre plus sur les animaux et leurs
                        environnements.</p>
                    </div>
                  </div>
                  <button className="visite-btn col-3 col-sm-5 rounded-5 mt-2 fs-5" type="button">Voir plus
                  </button>
                </div>
              </div>
              {/* Card Petit Train */}
              <div className="card accueil-services--train mb-3" data-section="train">
                <div className="row w-100 text-center d-flex  justify-content-center g-0">
                  <div className="img-service col-5 col-sm-12 p-2 p-md-3 p-lg-4 p-xl-5">
                    <img src="/uploads/images/services/PetitTrain.webp" className="img-fluid rounded-5"
                      alt="Image d'un petit train avec des voyageurs"/>
                  </div>
                  <div className="col-7 col-sm-12 d-flex justify-content-center p-2 my-auto">
                    <div className="card-body bg-warning rounded-5  p-1">
                      <h4 className="card-title ">Petit train</h4>
                      <p className="card-text">Une nouvelle façon de découvrir le zoo et les animaux de façon ludique avec le
                        petit train.</p>
                    </div>
                  </div>
                  <button className="train-btn col-3 col-sm-5 rounded-5 mt-2 fs-5" type="button">Voir plus
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      {/* Fin section services */}
      <section className="animaux">
        {/* Début section animaux*/}
        <img className="svg-top w-100" src="/uploads/images/svgDeco/SliceGreenMobil.svg" alt="demi-ellipse de couleur verte"/>
        <img className="svg-left" src="/uploads/images/svgDeco/RonOr&verLeft.svg" alt="Demi ellipse verte et orange"/>
        <img className="svg-right" src="/uploads/images/svgDeco/RonOr&verRight.svg" alt="Demi ellipse verte et orange"/>
        <div className="services-title text-center py-2 mb-lg-5">
          <h1 className="text-white">Nos stars</h1>
          <h6 className="text-white">Retrouvez nos célébrités</h6>
        </div>
        {/* Animaux cards */}
        <div className="container-animaux row row-cols-1 row-cols-md-3 g-4 d-flex justify-content-center mt-lg-5">
          <div className="col-6  mx-5 mx-md-2">
            {/* Animaux-1 cards */}
            <div className="card  accueil-card--renne col-8 h-100 mx-auto">
              <img src="/uploads/images/animals/René le cerf.webp" className="card-img-top rounded-circle"
                alt="Portrait d'un renne blanc"/>
              <div className="card-body rounded-5 text-center p-1">
                <h3 className="card-title">René le renne blanc</h3>
                <p className="card-text animaux-text">Emblème de le forêt de Brocéliande et mascotte de notre zoo.</p>
              </div>
            </div>
          </div>
          <div className="col-6 mx-5 mx-md-2">
            {/* Animaux-2 cards */}
            <div className="card accueil-card--flamant col-8 h-100 mx-auto">
              <img src="/uploads/images/animals/Jack le flamant.webp" className="card-img-top rounded-circle"
                alt="Portrait d'un flamant rose"/>
              <div className="card-body rounded-5 text-center p-1">
                <h3 className="card-title">Jack le flamant rose</h3>
                <p className="card-text animaux-text">Les pieds dans l'eau, Jack aime se pavaner devant les visiteurs.</p>
              </div>
            </div>
          </div>
          <div className="col-6 mx-5 mx-md-2">
            {/* Animaux-3 cards */}
            <div className="card accueil-card--ouistiti col-8 h-100 mx-auto">
              <img src="/uploads/images/animals/Jango le ouistiti.webp" className="card-img-top rounded-circle"
                alt="Portrait d'un ouistiti"/>
              <div className="card-body rounded-5 text-center p-1">
                <h3 className="card-title">Jango le ouistiti</h3>
                <p className="card-text animaux-text">Cacher dans les arbres il vous observe !! Soyez attentif.</p>
              </div>
            </div>
          </div>
          <div className="container-sophie col-6 mx-5 mx-md-2">
            {/* Animaux-4 cards */}
            <div className="card col-8 h-100 mx-auto">
              <img src="/uploads/images/animals/Sofie la girafe.webp" className="card-img-top rounded-circle"
                alt="Portrait d'une girafe"/>
              <div className="card-body rounded-5 text-center p-1">
                <h3 className="card-title">Sofie 
                  la girafe</h3>
                <p className="card-text animaux-text">Du haut de ses 4 mètres Sofie espère toujours être à la hauteur de votre rencontre.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <hr className="hr-avis"/>
      <section className="avis mb-5">
        <div className="container-fluid">
          <hr/>
          <div className="avis-title bg-danger rounded-circle w-100 text-center py-2 mb-lg-5 mt-5">
            <h1 className="text-white">Avis</h1>
            <h6 className="text-white">Vos avis comptent.</h6>
          </div>
          <div className="row row-cols-1 row-cols-md-3">
            {/* <img className="col  mx-auto" src="/assets/img/Accueil/Avis-1.svg" alt="Avis d'un client du zoo"/>
            <img className="col mx-auto" src="/assets/img/Accueil/Avis-2.svg" alt="Avis d'un client du zoo"/>
            <img className="col mx-auto" src="/assets/img/Accueil/Avis.svg" alt="Avis d'un client du zoo"/>
            <img className="avis-img col mx-auto" src="/assets/img/Accueil/Avis-1.svg" alt="Avis d'un client du zoo"/>
            <img className="avis-img col mx-auto" src="/assets/img/Accueil/Avis-2.svg" alt="Avis d'un client du zoo"/>
            <img className="avis-img col mx-auto" src="/assets/img/Accueil/Avis.svg" alt="Avis d'un client du zoo"/> */}
          </div>
        </div>
        <div className="col-12 d-flex justify-content-center ">
          <button type="button" className="avis-button col-lg-3 fs-5 fw-semibold rounded-3">Donnez votre avis !!</button>
        </div>
        <div className="overlay"></div>
        <div className="modal-form col-6">
          <img className="modal-form--exit" src="/uploads/img/svgDeco/croix.svg" alt="Image d'une croix"/>
          <form id="avis-form" className="row g-3" method="post">
            <div className="col-md-6">
              <label htmlFor="inputNom" className="form-label">Nom</label>
              <input type="text" className="form-control" id="inputNom" placeholder="Nom" required minLength={4} maxLength={20}
                size={22}/>
            </div>
            <div className="col-md-6">
              <label htmlFor="inputDate" className="form-label">Date de visite</label>
              <input type="date" required className="form-control" id="inputDate"/>
            </div>
            <div className="col-12">
              <label htmlFor="inputText" className="form-texte">Votre commentaire ici</label>
              <input type="text" className="form-control" id="inputText" placeholder="Commentaires" required minLength={4}
                maxLength={100} size={102}/>
                  </div>
                  <div className=" note d-flex flex-column align-items-center">
              <div className="content-etoile d-inline-flex justify-content-center">
                <div><img className="etoile" src="/uploads/img/svgDeco/star-filled.svg" alt="image d'étoile" data-value="1"/></div>
                <div><img className="etoile" src="/uploads/img/svgDeco/star.svg" alt="image d'étoile" data-value="2"/></div>
                <div><img className="etoile" src="/uploads/img/svgDeco/star.svg" alt="image d'étoile" data-value="3"/></div>
                <div><img className="etoile" src="/uploads/img/svgDeco/star.svg" alt="image d'étoile" data-value="4"/></div>
                <div><img className="etoile" src="/uploads/img/svgDeco/star.svg" alt="image d'étoile" data-value="5"/></div>
              </div>
            </div>
            <input type="hidden" id="rating" name="rating" value="0"/>
            <div className="col-12 d-flex justify-content-center">
              <button type="submit" className="btn btn-warning rounded-5 fw-semibold">Envoyer</button>
            </div>
          </form>
        </div>
      </section>

</>
  );
};

export default HomePage;