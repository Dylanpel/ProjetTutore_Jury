import React from "react";

export default function EtudiantForm({ etudiant, token }) {
    const isEdit = Boolean(etudiant);

    return (
        <>
            <div className="container py-4">
                <a href="/etudiant" className="d-inline-block text-muted small lien-user mb-2">&larr; Retour aux étudiants</a>

                <h1 className="fw-bold mb-1">{isEdit ? "Modifier un étudiant" : "Créer un étudiant"}</h1>
                <p className="text-muted small mb-5">Renseignez les informations de l'étudiant, les champs marqués d'un astérisque sont obligatoires.</p>

                <div className="card">
                    <div className="card-body p-4">
                        <form method="POST" action={isEdit ? `/etudiant/${etudiant.id}/edit` : '/etudiant/new'}>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Nom *</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="nom"
                                    placeholder="ex. Martin"
                                    defaultValue={etudiant?.nom || ''}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Prénom *</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="prenom"
                                    placeholder="ex. Alice"
                                    defaultValue={etudiant?.prenom || ''}
                                    required
                                />
                            </div>
                            
                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Numéro *</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="numero"
                                    placeholder="ex. E00123456"
                                    defaultValue={etudiant?.numero || ''}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label fw-semibold small">Remarque</label>
                                <textarea
                                    className="form-control"
                                    id="remarque"
                                    name="remarque"
                                    rows="3"
                                    placeholder="Note interne facultative..."
                                    defaultValue={etudiant?.remarque || ''}
                                ></textarea>
                            </div>

                            <input type="hidden" name="_token" value={token} />

                            <hr className="my-4" />

                            <div className="d-flex justify-content-end gap-2">
                                <a href="/etudiant" className="btn btn-primary">Annuler</a>
                                <button type="submit" className="btn btn-secondary">
                                    {isEdit ? 'Enregistrer les modifications' : "Créer un étudiant"}
                                </button>
                            </div>
                        </form> 
                    </div>
                    
                </div>
            </div>
        </>
    )
}