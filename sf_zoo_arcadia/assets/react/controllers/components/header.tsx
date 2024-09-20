import  { useState, useEffect } from 'react';

const Header: React.FC = () => {
  // État pour gérer l'utilisateur connecté et ses rôles
  const [isConnected, setIsConnected] = useState(false);
  const [userRoles, setUserRoles] = useState<string[]>([]);
  const [isLoading, setIsLoading] = useState(true);

  // Récupère l'état de connexion et les rôles depuis l'API
  useEffect(() => {
    fetch('/api/admin/user')
      .then(response => response.json())
      .then(data => {
        setIsConnected(data.isConnected);
        setUserRoles(data.roles);
        setIsLoading(false);  // Fin du chargement
      });
  }, []);

  if (isLoading) {
    return <p>Chargement...</p>; // Affichage pendant le chargement
  }

  return (
    <nav className="navbar navbar-expand-md bg-primary h-100 z-3 ">
      <div className="container-fluid justify-content-center">
        <div className="row w-100">
          <div className="container__menu-burger col-4 d-flex justify-content-start align-items-center">
            <img
              className="menu-burger"
              src="/assets/img/Accueil/Burger Nav.svg"
              alt="Menu burger"
            />
          </div>
          <div className="container__logo-arcadia col-4 col-md-2  d-flex  justify-content-center justify-content-md-start">
            <a className="navbar-brand m-0" href="/">
              <img
                className="logo-arcadia align-self-center"
                src="/assets/img/Accueil/Logo.svg"
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
              src="/assets/img/Accueil/Seconnecter.svg"
              alt="Icone se connecter"
            />)}
            { !isConnected && (
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
              data-show="connected"
            >
              Se déconnecter
            </button>)}
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Header;
