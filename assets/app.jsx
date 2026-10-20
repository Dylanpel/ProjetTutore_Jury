import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import LoginForm from './react/controllers/LoginForm';
import UserIndex from './react/controllers/user/UserIndex';
import UserShow from './react/controllers/user/UserShow';
import Navbar from './react/controllers/Navbar';

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