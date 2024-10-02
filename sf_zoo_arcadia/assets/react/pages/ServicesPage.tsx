import React, { useEffect, useState } from 'react';
import   { Service } from '../models/serviceInterface'
import   { SousService } from '../models/sousServiceInterface'


const ServicePage= () => {
  const[services, setService] = useState<Service[]>([]);
  const [sousService, setSousServices] = useState<SousService[]>([]);

  useEffect(() =>{
    fetch('/api/services')
    .then((response) => response.json())
    .then((data) => {
      setService(data);
    })
    .catch((error) => console.error('Erreur lors du chargement des services:', error));
}, []);return (
  <section className="les-services">
    {services.map((service, index) => (
      <div key={service.nomService} className="service-section">

      {/* SVG spécifique pour le haut de la première section */}
      {index === 0 && (
            <>
              <img
                className="first-section-top-decoration"
                src="/uploads/images/svgDeco/RecOrMob.svg"
                alt="Top decoration pour la première section"
              />
              <img
                className="first-section-second-top-decoration"
                src="/uploads/images/svgDeco/demiElOrLg.svg"
                alt="Second top decoration pour la première section"
              />
            </>
          )}
        <h2 className="service-title">{service.nomService}</h2>
        {/* <div className="service-content">
          {service.sousServices.map((sousService) => (
            <div key={sousService.id} className="service-card">
              <h4 className="sous-service-title">{sousService.nom}</h4>
              <p className="sous-service-description">{sousService.description}</p>
            </div>
          ))}
        </div> */}
      </div>
    ))}
  </section>
);
};

export default ServicePage;