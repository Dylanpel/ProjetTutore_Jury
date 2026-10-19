import React, { use } from "react";

export default function UserShow({ user }) {
    return (
        <div className="container">
            <h1>{user.login}</h1>
            <p><strong>Id :</strong> {user.id}</p>
            <p><strong>Roles :</strong> {user.roles.join(', ')}</p>
            <p><strong>Email :</strong> {user.email}</p>
            <p><strong>Remarque :</strong> {user.remarque}</p>

            <a href={`/user/${user.id}/edit`}>Modifier</a>
            {' '}

            <form method="post" action={`/user/${user.id}`} onSubmit={(e) => { if (!confirm('Supprimer cet utilisateur ?')) e.preventDefault(); }} style={{ display: 'inline' }}>
                <input type="hidden" name="_token" value={user.deleteToken} />
                <button type="submit">Supprimer</button>
            </form>

            <br />
            <a href="/user">Retour à la liste</a>
        </div>
    )
}