import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import LoginForm from './react/controllers/LoginForm';

const loginRoot = document.getElementById('login-root');
if(loginRoot) {
    const props = JSON.parse(loginRoot.dataset.props);
    createRoot(loginRoot).render(<LoginForm{...props} />);
}

console.log('app.js chargé avec Webpack Encore 🎉');