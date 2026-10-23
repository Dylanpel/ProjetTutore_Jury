import React from "react";
import '../user/shared.css';

export default function EtudiantShow( { etudiant }) {
    return (
        <>
        <div className="bg-primary text-center p-4">
            <span className="rounded-circle center bg-danger border border-white text-white fw-bold d-flex align-items-center justify-content-center mb-4" style={{ width: '120px', height: '120px', fontSize: '40px', fontWeight: 700 }}>{etudiant.nom.charAt(0).toUpperCase()}</span>
            <h1 className="text-white fw-bold mb-5">{etudiant.nom} {etudiant.prenom}</h1>          
        </div>
        <div className="container py-4" style={{ marginTop: '-65px'}}>
            <div className="row g-3 mb-4">
                <div className="col-md-4">
                    <div className="card rounded border border-white h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Identification :</p>
                            <p className="card-text">#{etudiant.id}</p>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card rounded border border-white h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Numéros :</p>
                            <p className="card-text">{etudiant.numero}</p>
                        </div>
                    </div>
                </div>
                
                <div className="col-md-4">
                    <div className="card border border-white rounded h-100">
                        <div className="card-body">
                            <p className="fw-semibold">Remarque :</p>
                            <p className="card-text">{etudiant.remarque || '-'}</p>
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
                                        <a className="btn btn-primary me-2" href={`/etudiant/${etudiant.id}/edit`}>Modifier</a>
                                    
                                        <form method="post" action={`/etudiant/${etudiant.id}`} onSubmit={(e) => { if (!confirm('Supprimer cet etudiant ?')) e.preventDefault(); }} style={{ display: 'inline' }}>
                                        <input type="hidden" name="_token" value={etudiant.deleteToken} />
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
                <a className="lien-user" href="/etudiant">Retour à la liste</a>
            </div>
        </div>
        </>
    )
}