import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import { createRoot } from 'react-dom/client';
import LoginForm from './react/controllers/LoginForm';
import UserIndex from './react/controllers/user/UserIndex';
import UserShow from './react/controllers/user/UserShow';
import Navbar from './react/controllers/Navbar';
import UserForm from './react/controllers/user/UserForm';
import EtudiantIndex from './react/controllers/Etudiant/EtudiantIndex';
import EtudiantShow from './react/controllers/Etudiant/EtudiantShow';
import EtudiantForm from './react/controllers/Etudiant/EtudiantForm';

const composants = {
    'navbar-root': Navbar,
    'login-root': LoginForm,
    'user-index-root': UserIndex,
    'user-show-root': UserShow,
    'user-form-root': UserForm,
    'etudiant-index-root': EtudiantIndex,
    'etudiant-show-root': EtudiantShow,
    'etudiant-form-root': EtudiantForm,
}

for(const [id, Component] of Object.entries(composants)) {
    const element = document.getElementById(id);

    if(!element) {
        continue;
    }

    const props = JSON.parse(element.dataset.props || '{}');
    createRoot(element).render(<Component {...props} />);
}
