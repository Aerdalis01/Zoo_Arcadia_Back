import { useState} from 'react';
import {Race} from '../../models/raceInterface'



  export const RaceForm: React.FC = () => {
    const [race, setRace] = useState<Race>({
      id: 0,
      nom: ''
    });
    const [error, setError] = useState<string | null>(null);
    const [successMessage, setSuccessMessage] = useState<string | null>(null);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
      const { name, value } = e.target;
      setRace({
          ...race,
          [name]: value,
      });
  };
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault(); // Empêche le rechargement de la page

      // Remplacer cette partie par votre logique pour envoyer les données à l'API
      if (!race.nom) {
          setError('Veuillez remplir tous les champs.');
          return;
      }

      // Exemple de requête POST
      fetch('/api/admin/races/new', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(race),
      })
      .then((response) => response.json())
      .then((data) => {
          console.log('Réponse de l\'API:', data);
          setSuccessMessage('Race ajouté avec succès !');
          // Reset form data après le succès
          setRace({
            id: 0,
            nom: ''
          });
      })
      .catch((error) => {
          console.error('Erreur lors de la soumission du formulaire:', error);
          setError('Erreur lors de l\'ajout de la race.');
      });
  };
    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label>Nom de la nouvelle race:</label>
                <input
                    type="text"
                    name="nom"
                    value={race.nom}
                    onChange={handleChange}
                />
            </div>
            <button type="submit">Soumettre</button>

{error && <p style={{ color: 'red' }}>{error}</p>}
{successMessage && <p style={{ color: 'green' }}>{successMessage}</p>}

      </form>
    );
  };
  
