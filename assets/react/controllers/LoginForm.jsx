import React from "react";
import './LoginForm.css';

export default function LoginForm({error, lastUsername, csrfToken}) {
    return (
        <div className="mx-auto vh100">
            <div className="container bg-light rounded-3 shadow login-form" style={{ maxWidth: '400px', marginTop: '80px' }}>
                <h1 className="text-center p-2">Se Connecter</h1>

                {error &&(
                    <div>
                        {error}
                    </div>
                )}
                <form method="post">
                    <div>
                        <label htmlFor="username" className="mb-2">Identifiant</label><br />
                        <input
                            type="text"
                            id="username"
                            name="login"
                            defaultValue={lastUsername}
                            required
                            autoFocus
                            className="form-control"
                        />
                    </div>

                    <div>
                        <label htmlFor="password" className="mb-2 mt-2">Mot de passe</label><br />
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            className="form-control"
                        />
                    </div>

                    <div className="form-check mb-3 mt-1">
                        <input
                            type="checkbox"
                            name="_remember_me"
                            id="remember_me"
                            className="form-check-input"
                        />
                        <label htmlFor="remember_me" className="form-check-label">
                            Se souvenir de moi
                        </label>
                    </div>

                    <input type="hidden" name="_csrf_token" value={csrfToken} />

                    <button type="submit" className="btn btn-primary mt-2">Se connecter</button>
                </form>
            </div>
        </div>
    );
}