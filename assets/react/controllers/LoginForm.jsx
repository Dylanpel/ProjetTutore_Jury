import React from "react";

export default function LoginForm({error, lastUsername, csrfToken}) {
    return (
        <div>
            <h1>Se Connecter</h1>

            {error &&(
                <div>
                    {error}
                </div>
            )}
            <form method="post">
                <div>
                    <label htmlFor="username">Login</label><br />
                    <input
                        type="text"
                        id="username"
                        name="login"
                        defaultValue={lastUsername}
                        required
                        autoFocus
                    />
                </div>

                <div>
                    <label htmlFor="password">Mot de passe</label><br />
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    />
                </div>

                <input type="hidden" name="_csrf_token" value={csrfToken} />

                <button type="submit">Se connecter</button>
            </form>
        </div>
    );
}