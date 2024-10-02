import { useState, useEffect } from "react";
import { Service } from "../../models/serviceInterface";
import { ImageForm } from "../../controllers/components/ImageForm";
import { SousServiceForm } from "../../controllers/components/SousServiceForm";

export function ServiceForm() {
  const [formData, setFormData] = useState<Service>({
    id: 0,
    nomService: '',
    titreService: '',
    description: '',
    typeService: '',
    
  });
  const [file, setFile] = useState<File | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };
  console.log("Données envoyées :", formData);

  
  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const formService = new FormData();
      
      formService.append('nomService', formData.nomService);
      formService.append('description', formData.description);
      formService.append('typeService', formData.typeService);
      formService.append('titreService', formData.titreService);

      if (file) {
        //Appel du timestamp pour générer un nom d'image unique
        const timestamp = new Date().getTime();
        //utilisation du timestamp dans le nom de l'image
        const imageNameGenerated = `${formData.nomService}-${timestamp}`;
        //enregistrament automatique du chemin de l'image
        const imagePathGenerated = `/${formData.nomService.toLowerCase()}`;
        const imageSubDirectory = `/uploads/images/services/${imageNameGenerated}`;

      formService.append('file', file);
      formService.append('nom', imageNameGenerated);
      formService.append('image_sub_directory', `/uploads/images/services/${imageNameGenerated}`);
      
    }
    formService.forEach((value, key) => {
      console.log(`${key}: ${value}`);
    });
    fetch("/api/services/new", {
      method: 'POST',
      body: formService,
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
        
        setSuccessMessage("Service ajouté avec succès !");
        setError(null);

        setFormData({
          id: 0,
          nomService: '',
          titreService: '',
          description: '',
          typeService: '',
        });
        setError(null);
      })
      
      .catch((error) => {
        console.error("Erreur lors de la soumission du formulaire:", error);
        setError("Erreur lors de l'ajout du service.");
      });
  };
  return (
    <form onSubmit={handleSubmit}>
      <div>
        <label>Nom du service :</label>
        <input
          type="text"
          name="nomService"
          value={formData.nomService}
          onChange={handleChange}
        />
      </div>

      <div>
        <label>Titre du service :</label>
        <input
          type="text"
          name="titreService"
          value={formData.titreService}
          onChange={handleChange}
        />
      </div>
      <div>
        <label>Description :</label>
        <input
          type="text"
          name="description"
          value={formData.description}
          onChange={handleChange}
        />
      </div>
      <div>
        <label>Type de service :</label>
        <input
          type="text"
          name="typeService"
          value={formData.typeService}
          onChange={handleChange}
        />
      </div>

      
      <ImageForm serviceName={formData.nomService} onImageSelect={setFile} />

      <button type="submit">Soumettre</button>

      {error && <p style={{ color: "red" }}>{error}</p>}
      {successMessage && <p style={{ color: "green" }}>{successMessage}</p>}
    </form>
  );
}
