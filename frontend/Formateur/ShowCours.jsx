import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { Container, Spinner, Button } from 'react-bootstrap';
import Swal from 'sweetalert2';
import '../style/ShowCours.css';  

const ShowCours = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [cours, setCours] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get(`http://localhost:8000/api/cours/${id}`)
      .then(res => {
        setCours(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error("Erreur lors du chargement du cours :", err);
        setLoading(false);
      });
  }, [id]);

  const handleDelete = () => {
    Swal.fire({
      title: 'Êtes-vous sûr ?',
      text: "Cette action est irréversible !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimer',
      cancelButtonText: 'Annuler'
    }).then(result => {
      if (result.isConfirmed) {
        axios.delete(`http://localhost:8000/api/cours/${id}`)
          .then(() => {
            Swal.fire('Supprimé!', 'Le cours a été supprimé.', 'success');
            navigate('/Formateur/ListeCours'); // Redirection après suppression
          })
          .catch(() => {
            Swal.fire('Erreur', 'La suppression a échoué.', 'error');
          });
      }
    });
  };

  if (loading) {
    return (
      <Container className="mt-5 text-center">
        <Spinner animation="border" />
      </Container>
    );
  }

  if (!cours) {
    return (
      <Container className="mt-5">
        <p>Cours non trouvé.</p>
        <Button onClick={() => navigate(-1)}>Retour</Button>
      </Container>
    );
  }

  return (
    <Container className="mt-5">
      <div className="card">
        <div className="card-header bg-primary text-white">
          <h4>Détails du Cours</h4>
        </div>
        <div className="card-body">
          <h5 className="card-title">{cours.titre}</h5>
          <p className="card-text"><strong>Contenu :</strong></p>
          <div dangerouslySetInnerHTML={{ __html: cours.contenu }} />

          <p><strong>Catégorie :</strong> {cours.categorie?.nom || cours.categorie?.name || 'Non spécifié'}</p>
          <p><strong>Chapitre :</strong> {cours.chapitre?.titre || 'Non spécifié'}</p>
          <p><strong>Formateur :</strong> {cours.formateur?.name || 'Non spécifié'}</p>

          {cours.image && (
            <>
              <p><strong>Image :</strong>  <img
                src={`http://localhost:8000/storage/${cours.image}`}
                alt="Image du cours"
                className="cours-image"
              /></p>
              
            </>
          )}

          {cours.type_pdf && (
            <>
              <p><strong>Fichier PDF :</strong> <Link to={`http://localhost:8000/storage/${cours.type_pdf}`}
                target="_blank" rel="noopener noreferrer"  className="btn btn-outline-secondary me-1" >Voir le PDF
          </Link></p>
             
          </>  )}    
          

          {cours.type_video && (
            <>
              <p className="mt-3"><strong>Vidéo :</strong> <video controls className="cours-video">
                <source src={`http://localhost:8000/storage/${cours.type_video}`} type="video/mp4" />
                Votre navigateur ne supporte pas la vidéo.
              </video></p>
            </>
          )}

          <div className="mt-4">
            <Link to="/Formateur/ListeCours" className="btn btn-secondary me-2">
              Retour à la liste
            </Link>
            <Link to={`/Formateur/EditCours/${cours.id}`} className="btn btn-warning me-2">
              Modifier
            </Link>
          
          </div>
        </div>
      </div>
    </Container>
  );
};

export default ShowCours;
