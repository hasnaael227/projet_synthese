import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from "react-router-dom";
import { Table, Container, Spinner, Button } from 'react-bootstrap';
import Swal from 'sweetalert2';

const ListeCours = () => {
  const [cours, setCours] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCours();
  }, []);

  const fetchCours = () => {
    axios.get('http://localhost:8000/api/cours')
      .then(res => {
        setCours(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error("Erreur chargement des cours :", err);
        setLoading(false);
      });
  };

  const handleDelete = (id) => {
    Swal.fire({
      title: 'Êtes-vous sûr ?',
      text: "Cette action est irréversible !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimer',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`http://localhost:8000/api/cours/${id}`)
          .then(() => {
            Swal.fire('Supprimé!', 'Le cours a été supprimé.', 'success');
            fetchCours(); // Refresh the list
          })
          .catch(() => {
            Swal.fire('Erreur', 'La suppression a échoué.', 'error');
          });
      }
    });
  };

  return (
    <Container className="mt-5">
      <h2>📚 Liste des cours</h2>
      <Link to="/Formateur/AddCours" className="btn btn-primary mb-3">
        <i className="fa-solid fa-plus"></i> Ajouter un Cours
      </Link>

      {loading ? (
        <Spinner animation="border" />
      ) : (
        <Table striped bordered hover className="mt-3" responsive>
          <thead>
            <tr>
              <th>Image</th>  {/* Nouvelle colonne image */}
              <th>Titre</th>
              <th>Contenu</th>
              <th>Catégorie</th>
              <th>Chapitre</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {cours.map(c => (
              <tr key={c.id}>
                <td style={{ width: 100 }}>
                  {c.image ? (
                    <img
                      src={`http://localhost:8000/storage/${c.image}`} // adapte ce chemin selon ta config
                      alt={c.titre}
                      style={{ width: '80px', height: '50px', objectFit: 'cover', borderRadius: '5px' }}
                    />
                  ) : (
                    <span>Pas d'image</span>
                  )}
                </td>
                <td>{c.titre}</td>
                <td>{c.contenu.replace(/<[^>]*>/g, '').slice(0, 100)}...</td>
                <td>{c.categorie?.name}</td>
                <td>{c.chapitre?.titre}</td>
                
                <td>
                  <Link to={`/Formateur/ShowCours/${c.id}`} className="btn btn-info me-1">
                    <i className="bi bi-eye"></i>
                  </Link>   
                  <Link to={`/Formateur/EditCours/${c.id}`} className="btn btn-warning me-2">
                    <i className="bi bi-pencil-square"></i>
                  </Link>
                  <Button variant="danger" onClick={() => handleDelete(c.id)}>            
                    <i className="bi bi-trash"></i>
                  </Button>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      )}
    </Container>
  );
};

export default ListeCours;
