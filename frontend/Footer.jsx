import React from 'react';
import '../components/style/Footer.css'; 

const Footer = () => {
  return (
    <footer className="bg-dark text-white pt-5 pb-4 mt-5">
      <div className="container text-md-left">
        <div className="row text-md-left">

          <div className="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
            <h5 className="text-uppercase mb-4 font-weight-bold ">SkillUp</h5>
            <p>
              Votre plateforme d'apprentissage en ligne pour développer vos compétences à votre rythme.
            </p>
          </div>

          <div className="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 className="text-uppercase mb-4 font-weight-bold text-dark">Cours</h5>
            <p><a href="#" className=" text-decoration-none">Développement</a></p>
            <p><a href="#" className="text-decoration-none">Business</a></p>
            <p><a href="#" className="text-decoration-none">Design</a></p>
            <p><a href="#" className="text-decoration-none">Marketing</a></p>
          </div>

          <div className="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 className="text-uppercase mb-4 font-weight-bold text-dark">Entreprise</h5>
            <p><a href="#" className="text-decoration-none">À propos</a></p>
            <p><a href="#" className="text-decoration-none">Contact</a></p>
            <p><a href="#" className="text-decoration-none">Carrières</a></p>
          </div>

          <div className="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h5 className="text-uppercase mb-4 font-weight-bold text-dark">Légal</h5>
            <p><a href="#" className="text-decoration-none">Conditions d'utilisation</a></p>
            <p><a href="#" className="text-decoration-none">Politique de confidentialité</a></p>
          </div>

        </div>

        <hr className="mb-4" />
        <div className="row align-items-center">
          <div className="col-md-7 col-lg-8">
            <p>© 2025 SkillUp. Tous droits réservés.</p>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
