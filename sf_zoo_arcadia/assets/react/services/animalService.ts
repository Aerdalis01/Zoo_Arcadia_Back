export class AnimalService {

  create(data: Record<string, any>): Promise<any> {
      return fetch('/api/admin/animaux/new', {
          method: "POST",
          mode: "same-origin",
          headers: {
              "Content-Type": "application/json",
          },
          // Mettre toutes les valeurs qui ne sont pas nullable true dans l'entité animal
          body: JSON.stringify({
              'prenom' : data.prenom,
              'race' : data.race,
              'habitat': data.habitat
          })
      });
  }

}

