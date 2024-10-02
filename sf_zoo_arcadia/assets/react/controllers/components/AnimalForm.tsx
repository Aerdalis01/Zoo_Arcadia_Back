import { useState, useEffect } from 'react';
import {Habitat} from '../../models/habitatInterface'
import {Race} from '../../models/raceInterface'
import {Image} from '../../models/imageInterface'

interface FormData {
    prenom: string;
    habitat: string;
    race: string;
    image: string
}


export  function AnimalForm () {
//Remplacer "amount" par la valeur prenom
//Fetch pour récupérer habitats list le mettre dans useState et afficher le contenu dans un select

const [formData, setFormData] = useState<FormData>({
    prenom: '',
    habitat: '',
    race: '',
    image: ''
});
    const [habitats, setHabitats] = useState<Habitat[]>([]);
    const [races, setRaces] = useState<Race[]>([]);
    const [images, setImages] = useState<Image[]>([]);
    const [error, setError] = useState<string | null>(null);
    const [successMessage, setSuccessMessage] = useState<string | null>(null);

    useEffect(() => {
        fetch('/api/admin/habitats')
            .then((response) => response.json())
            .then((data) => {
                setHabitats(data);
            })
            .catch((error) => {
                console.error('Erreur lors du fetch des habitats:', error);
                setError('Erreur lors du chargement des habitats.');
            });
    }, []);
    useEffect(() => {
        fetch('/api/admin/races')
            .then((response) => response.json())
            .then((data) => {
                setRaces(data);
            })
            .catch((error) => {
                console.error('Erreur lors du fetch des races:', error);
                setError('Erreur lors du chargement des races.');
            });
    }, []);
    useEffect(() => {
        fetch('/api/admin/images')
            .then((response) => response.json())
            .then((data) => {
                setImages(data);
            })
            .catch((error) => {
                console.error('Erreur lors du fetch des images:', error);
                setError('Erreur lors du chargement des images.');
            });
    }, []);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };
    console.log('Données envoyées :', formData);
    // Gestion de la soumission du formulaire
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault(); // Empêche le rechargement de la page

        // Remplacer cette partie par votre logique pour envoyer les données à l'API
        if (!formData.prenom || !formData.habitat || !formData.race || !formData.image) {
            setError('Veuillez remplir tous les champs.');
            return;
        }

        // Exemple de requête POST
        fetch('/api/admin/animaux/new', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
        .then((response) => response.json())
        .then((data) => {
            console.log('Réponse de l\'API:', data);
            setSuccessMessage('Animal ajouté avec succès !');
            // Reset form data après le succès
            setFormData({
                prenom: '',
                habitat: '',
                race: '',
                image: ''
            });
            setError(null);
        })
        .catch((error) => {
            console.error('Erreur lors de la soumission du formulaire:', error);
            setError('Erreur lors de l\'ajout de l\'animal.');
        });
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label>Prénom:</label>
                <input
                    type="text"
                    name="prenom"
                    value={formData.prenom}
                    onChange={handleChange}
                />
            </div>

            <div>
                <label>Habitat:</label>
                <select
                    name="habitat"
                    value={formData.habitat}
                    onChange={handleChange}
                >
                    <option value="">Sélectionner un habitat</option>
                    {habitats.map((habitat) => (
                        <option key={habitat.id} value={habitat.id}>
                            {habitat.nom}
                        </option>
                    ))}
                </select>
            </div>

            <div>
                <label>Race:</label>
                <select
                    name="race"
                    value={formData.race}
                    onChange={handleChange}
                >
                    <option value="">Sélectionner une race</option>
                    {races.map((race) => (
                        <option key={race.id} value={race.id}>
                            {race.nom}
                        </option>
                    ))}
                </select>
            </div>
            <div>
                <label>Image:</label>
                <select
                    name="image"
                    value={formData.image}
                    onChange={handleChange}
                >
                    <option value="">Sélectionner une image</option>
                    {images.map((image) => (
                        <option key={image.id} value={image.id}>
                            {image.nom}
                        </option>
                    ))}
                </select>
            </div>

            <button type="submit">Soumettre</button>

            {error && <p style={{ color: 'red' }}>{error}</p>}
            {successMessage && <p style={{ color: 'green' }}>{successMessage}</p>}

        </form>
    );
}