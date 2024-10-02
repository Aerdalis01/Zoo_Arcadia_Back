import  { useState, useEffect } from 'react';


const Header: React.FC = () => {
  // État pour gérer l'utilisateur connecté et ses rôles
  const [isConnected, setIsConnected] = useState(false);
  const [userRoles, setUserRoles] = useState<string[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // Récupère l'état de connexion et les rôles depuis l'API
  useEffect(() => {
    fetch('/api/admin/user')
      .then(response => {
        // Afficher la réponse dans la console pour voir son contenu
  
        // Vérifier le type de contenu (Content-Type) de la réponse
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
          // Si la réponse est en JSON, la parser
          return response.json();
        } else {
          // Si ce n'est pas du JSON, afficher le texte brut
          return response.text();
        }
      })
      .then(data => {
  
        if (typeof data === 'string') {
          throw new Error(`La réponse n'est pas un JSON valide: ${data}`);
        }
  
        // Si c'est du JSON valide, mettre à jour les états
        setIsConnected(data.isConnected);
        setUserRoles(data.roles);
        setIsLoading(false);
      })
      .catch(err => {
        console.error('Erreur lors de la requête ou du parsing JSON:', err);
        setIsLoading(false);
      });
  }, []);

  return (
    
  <header id="header" className="header">
    <nav className="navbar navbar-expand-md bg-primary h-100 z-3 ">
      <div className="container-fluid justify-content-center">
        <div className="row w-100">
          <div className="container__menu-burger col-4 d-flex justify-content-start align-items-center">
            <img
              className="menu-burger"
              src="/uploads/images/svgDeco/Burger Nav.svg"
              alt="Menu burger"
            />
          </div>
          <div className="container__logo-arcadia col-4 col-md-2  d-flex  justify-content-center justify-content-md-start">
            <a className="navbar-brand m-0" href="/">
              <img
                className="logo-arcadia align-self-center"
                src="/uploads/images/svgDeco/Logo.svg"
                alt="Logo du zoo Arcadia"
              />
            </a>
            <h3 className="align-items-center text-center px-4 text-warning d-none d-lg-flex">
              Zoo Arcadia
            </h3>
          </div>
          <div
            className="collapse navbar-collapse col-7 col-xl-8"
            id="navbarNav"
          >
            <ul className="navbar-nav text-center w-100 d-flex justify-content-center">
              <li className="nav-item col-2 ">
                <a
                  className="nav-link active text-warning fw-semibold fs-5"
                  aria-current="page"
                  href="/"
                >
                  Accueil
                </a>
              </li>
              <li className="nav-item col-2">
                <a
                  className="nav-link text-warning fw-semibold fs-5"
                  href="/services"
                >
                  Services
                </a>
              </li>
              <li className="nav-item col-2">
                <a
                  className="nav-link text-warning fw-semibold fs-5"
                  href="/habitats"
                >
                  Habitats
                </a>
              </li>
              <li className="nav-item col-2">
                <a
                  className="nav-link text-warning fw-semibold fs-5"
                  href="/contact"
                >
                  Contact
                </a>
              </li>
              { isConnected && (
              <li className="nav-item col-2" data-show="connected">
                <div>
                  { userRoles.includes('employe') && (  
                  <a
                    className="nav-link text-warning fw-semibold fs-5"
                    href="/employe"
                  >
                    Espace employe
                  </a> )}
                  { userRoles.includes('veterinaire') && (  
                  <a
                    className="nav-link text-warning fw-semibold fs-5"
                    href="/veto"
                    data-show="veto"
                  >
                    Espace vétérinaire
                  </a>)}
                  {userRoles.includes('admin') && (
                  <a
                    className="nav-link text-warning fw-semibold fs-5"
                    href="/admin"
                    data-show="admin"
                  >
                    Espace admin
                  </a> )}
                </div>
              </li>)}
            </ul>
          </div>
          <div className="container__icone-user col-4  d-flex align-items-center justify-content-end ">
            { !isConnected && (
            <img
              className="icon-user"
              src="/uploads/images/svgDeco/Seconnecter.svg"
              alt="Icone se connecter"
            />)}
            { isConnected && (
            <button
              id="btn2NavbarDeco"
              className="btn btn-navbar--deco btn-warning fw-semibold"
              type="button"
            >
              Se déconnecter
            </button>)}
          </div>

          <div className="container-btn--navbar  col-md-2  col-xl-2 d-flex align-items-center justify-content-end">
          { !isConnected && (
            <button
              id="btnNavbarCo"
              className="btn btn-navbar btn-warning fw-semibold px-2"
              type="button"
            >
              Se connecter
            </button>)}
            { isConnected && (
            <button
              id="btnNavbarDeco"
              className="btn btn-navbar--deco btn-warning fw-semibold px-2"
              type="button"
            >
              Se déconnecter
            </button>)}
          </div>
        </div>
      </div>
    </nav>
    {/* Modal Menu */}
    <div className="container-fluid modal-menu d-flex flex-column align-items-center text-center h-100 w-100 p-0">
        <div className="content-exit d-flex justify-content-center align-items-center bg-primary w-100">
          <a className="logo" href="/">
            <img src="/uploads/images/svgDeco/Logo.svg" alt="Logo du zoo Arcadia" />
          </a>
          <img className="menu-exit" src="/uploads/images/svgDeco/croix.svg" alt="Image d'une croix" />
        </div>
        <ul className="navbar-nav text-center d-flex align-items-center mb-5 w-100">
          <li className="nav-item col-3 mb-5">
            <a className="nav-link fs-1 active fw-semibold" aria-current="page" href="/">
              Accueil
            </a>
          </li>
          <li className="nav-item col-3 mb-5">
            <a className="nav-link fs-1 fw-semibold" href="/services">
              Service
            </a>
          </li>
          <li className="nav-item col-3 mb-5">
            <a className="nav-link fs-1 fw-semibold" href="/habitats">
              Habitats
            </a>
          </li>
          <li className="nav-item col-3 mb-5">
            <a className="nav-link fs-1 fw-semibold" href="/contact">
              Contact
            </a>
          </li>
          {isConnected && (
            <li className="nav-item col-3 mb-5" data-show="connected">
              {userRoles.includes('employe') && (
                <a className="nav-link fs-1 fw-semibold" href="/employe" data-show="employe">
                  Espace employe
                </a>
              )}
              {userRoles.includes('veterinaire') && (
                <a className="nav-link fs-1 fw-semibold" href="/veto" data-show="veto">
                  Espace vétérinaire
                </a>
              )}
              {userRoles.includes('admin') && (
                <a className="nav-link fs-1 fw-semibold" href="/admin" data-show="admin">
                  Espace admin
                </a>
              )}
            </li>
          )}
          {!isConnected && (
            <li className="nav-item item-connexion col-3 mb-5 w-100">
              <a className="nav-link fs-1 fw-semibold" href="/connexion" data-show="disconnected">
                Se connecter
              </a>
              <a id="btn3NavbarDeco" className="nav-link--deco fs-1 fw-semibold" data-show="connected">
                Se déconnecter
              </a>
            </li>
          )}
        </ul>
      </div>
    </header>
  );
};

export default Header;
