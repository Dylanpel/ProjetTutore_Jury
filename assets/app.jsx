import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import React from 'react';
import { createRoot } from 'react-dom/client';
import LoginForm from './react/controllers/LoginForm';

const loginRoot = document.getElementById('login-root');
if(loginRoot) {
    const props = JSON.parse(loginRoot.dataset.props);
    createRoot(loginRoot).render(<LoginForm{...props} />);
}
