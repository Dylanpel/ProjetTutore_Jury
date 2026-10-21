import React, { use } from "react";
import './shared.css';

export default function UserShow({ user }) {
    return (
        <>
        <div className="bg-primary text-center p-4">
            <span className="rounded-circle center bg-danger border border-white text-white fw-bold d-flex align-items-center justify-content-center mb-4" style={{ width: '120px', height: '120px', fontSize: '40px', fontWeight: 700 }}>{user.login.charAt(0).toUpperCase()}</span>
            <h1 className="text-white fw-bold">{user.login}</h1>
            {user.roles.map(role => (
                <span key={role} className="badge bg-danger border border-white rounded-pill p-2 ps-3 pe-3 me-2 mb-5">{role}</span>
            ))}
        </div>
        <div className="container py-4" style={{ marginTop: '-65px'}}>
            <div className="row g-3 mb-4">
                <div className="col-md-4">
                    <div className="card rounded border border-white h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Identifiant</p>
                            <p className="card-text">#{user.id}</p>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card rounded border border-white h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Email :</p>
                            <p className="card-text">{user.email}</p>
                        </div>
                    </div>
                </div>
                
                <div className="col-md-4">
                    <div className="card border border-white rounded h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Remarque :</p>
                            <p className="card-text">{user.remarque || '-'}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div className="container p-0">
                <div className="row g-2">
                    <div className="col-md-12">
                        <div className="card border border-white rounded">
                            <div className="card-body">
                                <p className="fw-semibold">Gérer ce compte</p>
                                <div className="d-flex justify-content-between">
                                     <p className="card-text">Modifier les informations ou supprimer ce compte.</p>
                                     <div>
                                        <a className="btn btn-primary me-2" href={`/user/${user.id}/edit`}>Modifier</a>
                                    
                                        <form method="post" action={`/user/${user.id}`} onSubmit={(e) => { if (!confirm('Supprimer cet utilisateur ?')) e.preventDefault(); }} style={{ display: 'inline' }}>
                                        <input type="hidden" name="_token" value={user.deleteToken} />
                                        <button className="btn btn-secondary" type="submit">Supprimer</button>
                                        </form>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mt-4">
                <a className="lien-user" href="/user">Retour à la liste</a>
            </div>
        </div>
        </>
    )
}