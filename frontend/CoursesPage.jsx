import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import '../components/style/Cours.css';

const CoursesPage = () => {
  const [categories, setCategories] = useState([]);
  const [filteredCategories, setFilteredCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [search, setSearch] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('');
  const [selectedLevel, setSelectedLevel] = useState('');

  const niveaux = ['Débutant', 'Intermédiaire', 'Avancé'];

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/categories');
        setCategories(response.data);
        setFilteredCategories(response.data);
      } catch (err) {
        setError('Erreur lors du chargement des catégories.');
      } finally {
        setLoading(false);
      }
    };

    fetchCategories();
  }, []);

  useEffect(() => {
    filterResults();
  }, [search, selectedCategory, selectedLevel]);

  const filterResults = () => {
    const results = categories.filter(c => {
      const matchSearch = c.name.toLowerCase().includes(search.toLowerCase());
      const matchCategory = selectedCategory ? c.name === selectedCategory : true;
      const matchLevel = selectedLevel ? c.niveau === selectedLevel : true;
      return matchSearch && matchCategory && matchLevel;
    });

    setFilteredCategories(results);
  };

  if (loading) return <p className="text-center mt-5">Chargement...</p>;
  if (error) return <p className="text-center mt-5 text-danger">{error}</p>;

  return (
    <div className="container mt-5">
      <br /><br /><br />
      <h1 className="text-center fw-bold">Explorez Nos Cours</h1>
      <p className="text-center text-muted">Découvrez notre sélection de cours pour développer vos compétences</p>

      <div className="row justify-content-center mt-4 mb-5">
        <div className="col-md-4 mb-2">
          <input
            type="text"
            className="form-control"
            placeholder="Rechercher des cours..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />
        </div>
        <div className="col-md-3 mb-2">
          <select className="form-select" value={selectedCategory} onChange={(e) => setSelectedCategory(e.target.value)}>
            <option value="">Toutes les catégories</option>
            {categories.map(c => (
              <option key={c.id} value={c.name}>{c.name}</option>
            ))}
          </select>
        </div>
        {/* <div className="col-md-3 mb-2">
          <select className="form-select" value={selectedLevel} onChange={(e) => setSelectedLevel(e.target.value)}>
            <option value="">Tous les niveaux</option>
            {niveaux.map(niveau => (
              <option key={niveau} value={niveau}>{niveau}</option>
            ))}
          </select>
        </div> */}
      </div>

      <h5 className="mb-3">{filteredCategories.length} cours trouvés</h5>
      <div className="row">
        {filteredCategories.length > 0 ? (
          filteredCategories.map(category => (
            <div className="col-md-6 col-lg-4 mb-4" key={category.id}>
              <div className="card h-100 shadow-sm rounded">
                <img
                  src={category.image ? `http://localhost:8000/storage/${category.image}` : 'https://via.placeholder.com/300x200'}
                  className="card-img-top"
                  alt={category.name}
                  style={{ height: '200px', objectFit: 'cover' }}
                />
                <div className="card-body d-flex flex-column">
                  <h5 className="card-title">{category.name}</h5>
                  <p className="card-text flex-grow-1">{category.description || 'Pas de description'}</p>
                 <Link to={`/DetailsCours/${category.id}`} className="btn btn-primary mt-auto">
                    Voir plus
                  </Link>

                </div>
              </div>
            </div>
          ))
        ) : (
          <p className="text-center">Aucun cours trouvé.</p>
        )}
      </div>
    </div>
  );
};

export default CoursesPage;
