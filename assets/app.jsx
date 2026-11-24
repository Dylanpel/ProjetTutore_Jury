import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import LoginForm from './react/controllers/LoginForm';
import UserIndex from './react/controllers/user/UserIndex';
import UserShow from './react/controllers/user/UserShow';
import Navbar from './react/controllers/Navbar';
import UserForm from './react/controllers/user/UserForm';
import EtudiantIndex from './react/controllers/Etudiant/EtudiantIndex';
import EtudiantShow from './react/controllers/Etudiant/EtudiantShow';

const loginRoot = document.getElementById('login-root');
if(loginRoot) {
    const props = JSON.parse(loginRoot.dataset.props);
    createRoot(loginRoot).render(<LoginForm{...props} />);
}

const userIndexRoot = document.getElementById('user-index-root');
if(userIndexRoot) {
    const props = JSON.parse(userIndexRoot.dataset.props);
    createRoot(userIndexRoot).render(<UserIndex{...props} />);
}

const userShowRoot = document.getElementById('user-show-root');
if(userShowRoot) {
    const props = JSON.parse(userShowRoot.dataset.props);
    createRoot(userShowRoot).render(<UserShow{...props} />);
}

const navbarRoot = document.getElementById("navbar-root");
const props = JSON.parse(navbarRoot.dataset.props);
createRoot(navbarRoot).render(<Navbar{...props} />);

const userFormRoot = document.getElementById("user-form-root");
if(userFormRoot) {
    const props = JSON.parse(userFormRoot.dataset.props);
    createRoot(userFormRoot).render(<UserForm{...props} />);
}

const etudiantIndexRoot = document.getElementById('etudiant-index-root');
if(etudiantIndexRoot) {
    const props = JSON.parse(etudiantIndexRoot.dataset.props);
    createRoot(etudiantIndexRoot).render(<EtudiantIndex{...props} />);
}

const etudiantShowRoot = document.getElementById('etudiant-show-root');
if(etudiantShowRoot) {
    const props = JSON.parse(etudiantShowRoot.dataset.props);
    createRoot(etudiantShowRoot).render(<EtudiantShow{...props} />);
}