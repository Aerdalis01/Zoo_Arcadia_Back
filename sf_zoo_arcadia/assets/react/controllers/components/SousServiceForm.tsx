import { useState, useEffect } from "react";
import { SousService } from "../../models/sousServiceInterface";
import { ImageForm } from "../../controllers/components/ImageForm";
import { Service } from "../../models/serviceInterface";

export function SousServiceForm() {
  const [formData, setFormData] = useState<SousService>({
    id: 0,
    nomSousService: '',
    description: '',
    typeSousService: '',
    idService: '',
  });
  
  const [file, setFile] = useState<File | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);
  const [service, setServices] = useState<Service[]>([]);

  useEffect(() => {
    fetch("/api/services")
      .then((response) => response.json())
            .then((data) => setServices(data))
            .catch((error) => console.error("Erreur lors du chargement des services", error));
    }, []);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const formSousService = new FormData();
    formSousService.append('nomSousService', formData.nomSousService);
    formSousService.append('description', formData.description);
    formSousService.append('typeSousService', formData.typeSousService);
    formSousService.append('idService', formData.idService);
    if (file) {
      //Appel du timestamp pour générer un nom d'image unique
      const timestamp = new Date().getTime();
      //utilisation du timestamp dans le nom de l'image
      const imageNameGenerated = `${formData.nomSousService}-${timestamp}`;
      //enregistrament automatique du chemin de l'image
      const imagePathGenerated = `/${formData.nomSousService.toLowerCase()}`;
      const imageSubDirectory = `/uploads/images/services/${imageNameGenerated}`;
      
      
      formSousService.append('file', file);
      formSousService.append('nom', imageNameGenerated);
      formSousService.append('image_sub_directory', `/uploads/images/services/${imageNameGenerated}`);

    }
    console.log('FormData envoyé :', Object.fromEntries((formSousService as any).entries()));

    fetch("/api/sousService/new", {
      method: 'POST',
      body: formSousService,
    })
    
    .then((response) => {
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
          return response.json(); 
      } else {
          return response.text(); 
      }
  })
    .then((data) => {
      setSuccessMessage("Sous-Service ajouté avec succès !");
      setError(null);
      setFormData({
        id: 0,
        nomSousService: '',
        description: '',
        typeSousService: '',
        idService: ''
      });
      setFile(null);
    })
    .catch((error) => {
      console.error("Erreur lors de la soumission du formulaire:", error);
      setError("Erreur lors de l'ajout du service.");
    });
    };

    return (
      <form onSubmit={handleSubmit}>
        <div>
          <label>Nom du sous service :</label>
          <input type="text" name="nomSousService" value={formData.nomSousService} onChange={handleChange} />
        </div>
        
        <div>
          <label>Description :</label>
          <input type="text" name="description" value={formData.description} onChange={handleChange} />
        </div>
        <div>
          <label>Type de sous service :</label>
          <input type="text" name="typeSousService" value={formData.typeSousService} onChange={handleChange} />
        </div>
        
        <ImageForm serviceName={formData.nomSousService} onImageSelect={setFile} />

        <div>
        <label>Service :</label>
        <select
          name="idService"
          value={formData.idService}
          onChange={handleChange}
        >
          <option value="">Sélectionner un service</option>
            {service.map((service) => (
              <option key={service.id} value={service.id}>
                {service.nomService}
              </option>
            ))}
            
        </select>
      </div>

        <button type="submit">Soumettre</button>
  
        {error && <p style={{ color: "red" }}>{error}</p>}
        {successMessage && <p style={{ color: "green" }}>{successMessage}</p>}
      </form>
    );
  }