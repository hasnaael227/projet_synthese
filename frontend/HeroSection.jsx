import React from 'react';
import { Link } from 'react-router-dom';
import '../components/style/HomePage.css';
import image from '../components/image/study.jpeg';
import '../components/style/Navbar.css';

const HeroSection = () => {
  return (
    <din>
    <section className="hero-section d-flex align-items-center">
      <div className="container">
        <div className="row align-items-center">
          <div className="col-md-6 text-start">
            <h1><strong>Apprenez</strong><br /><span className="text-primary">de nouvelles compétences</span></h1>
            <p className="text-muted">
              Découvrez des milliers de cours en ligne dispensés par des experts.<br />
              Développez vos compétences et atteignez vos objectifs professionnels.
            </p>
            <button className="btn btn-primary mt-3">Découvrir les cours</button>
          </div>
          <div className="col-md-6">
            <img src={image} alt="Étudiants" className="img-fluid rounded shadow" />
          </div>
        </div>
      </div>
    </section>
    <br /><br />
    <section className="stats-section bg-light py-5 text-center">
  <div className="container">
    <div className="row">
      <div className="col-md-3">
        <h2 className="text-primary">9K+</h2>
        <p>Apprenants</p>
      </div>
      <div className="col-md-3">
        <h2 className="text-primary">200+</h2>
        <p>Cours en ligne</p>
      </div>
      <div className="col-md-3">
        <h2 className="text-primary">70+</h2>
        <p>Formateurs experts</p>
      </div>
      <div className="col-md-3">
        <h2 className="text-primary">4.9/5</h2>
        <p>Note moyenne</p>
      </div>
    </div>
  </div>
</section><br /><br />

<section className="cta-section text-center text-white py-5" style={{ backgroundColor: 'rgb(103, 136, 245)' }}>
  <div className="container">
    <h2>Prêt à démarrer ?</h2>
    <p>Inscrivez-vous dès aujourd'hui et commencez à apprendre gratuitement !</p>
    <Link to="/register" className="btn btn-light mt-3">S'inscrire maintenant</Link>
  </div>
</section>



    </din>
  );
};

export default HeroSection;
