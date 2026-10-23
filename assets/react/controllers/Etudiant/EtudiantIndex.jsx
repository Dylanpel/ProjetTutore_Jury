import React from "react";
import '../user/shared.css';

export default function EtudiantIndex({ etudiants }) {
    return (
        <>
            <div className="min-vh-100">
                <div className="container py-4">
                    <div className="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h1 className="h3 mb-o">Étudiants</h1>
                            <div className="text-muted small">{etudiants.length} étudiants</div>
                        </div>
                            <a href="etudiant/new" className="btn btn-secondary">+ Nouvelle Étudiants</a>
                    </div>

                    <div className="table-responsive">
                        <table className="table align-middle bg-white">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Numero</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Remarque</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {etudiants.map(etudiant => (
                                    <tr key={etudiant.id}>
                                        <td>{etudiant.id}</td>
                                        <td>
                                            {etudiant.numero}
                                        </td>
                                        <td>
                                             {etudiant.nom}
                                        </td>
                                        <td>{etudiant.prenom}</td>
                                        <td className="text-muted">{etudiant.remarque || '-'}</td>
                                        <td className="text-end">
                                            <a href={`/etudiant/${etudiant.id}`} className="me-2 lien-user">Voir</a>
                                            {' '}
                                            <a href={`/etudiant/${etudiant.id}/edit`}className="lien-user">Modifier</a>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </>
    )
}