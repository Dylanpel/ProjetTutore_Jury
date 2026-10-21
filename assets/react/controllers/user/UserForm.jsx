import React from "react";

export default function UserForm({ user, token }) {
    const isEdit = Boolean(user);

    return (
        <>
            <div className="container py-4">
                <a href="/user" className="d-inline-block text-muted small lien-user mb-2">&larr; Retour aux utilisateurs</a>

                <h1 className="fw-bold mb-1">{isEdit ? "Modifier l'utilisateur" : "Créer un utilsateur"}</h1>
                <p className="text-muted small mb-5">Renseignez les informations du compte, les champs marqués d'un astérisque sont obligatoires.</p>

                <div className="card">
                    <div className="card-body p-4">
                        <form method="POST" action={isEdit ? `/user/${user.id}/edit` : '/user/new'}>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Login *</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="login"
                                    placeholder="ex. prof.martin"
                                    defaultValue={user?.login || ''}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Email *</label>
                                <input
                                    type="email"
                                    className="form-control"
                                    name="email"
                                    placeholder="ex. martin@exemple.fr"
                                    defaultValue={user?.email || ''}
                                    required
                                />
                            </div>

                            {!isEdit && (
                                <div className="mb-3">
                                    <label className="form-label fw-semibold small">Mot de passe *</label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="password"
                                        placeholder="••••••••"
                                        required={!isEdit}
                                    />
                                </div>
                            )}

                            <div className="mb-3">
                                <label className="form-label fw-semibold small d-block">Rôles *</label>
                                <div className="d-flex flex-wrap gap-2">
                                    {['ROLE_USER', 'ROLE_ADMIN', 'ROLE_MANAGER'].map(role => (
                                        <div key={role} className="border rounded px-3 py-2">
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    name="roles[]"
                                                    value={role}
                                                    id={`role-${role}`}
                                                    defaultChecked={user?.roles?.includes(role) ?? (role === 'ROLE_USER')}
                                                />
                                                <label className="form-check-label" htmlFor={`role-${role}`}>{role}</label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Remarque</label>
                                <textarea
                                    className="form-control"
                                    id="remarque"
                                    name="remarque"
                                    rows="3"
                                    placeholder="Note interne facultative..."
                                    defaultValue={user?.remarque || ''}
                                ></textarea>
                            </div>

                            <input type="hidden" name="_token" value={token} />

                            <hr className="my-4" />

                            <div className="d-flex justify-content-end gap-2">
                                <a href="/user" className="btn btn-primary">Annuler</a>
                                <button type="submit" className="btn btn-secondary">
                                    {isEdit ? 'Enregistrer les modifications' : "Créer l'utilisateur"}
                                </button>
                            </div>
                        </form> 
                    </div>
                    
                </div>
            </div>
        </>
    )
}