import React from "react";
import './shared.css';

export default function UserIndex({ users }) {
    return (
        <>
            <div className="min-vh-100">
                <div className="container py-4">
                    <div className="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h1 className="h3 mb-o">Utilisateurs</h1>
                            <div className="text-muted small">{users.length} comptes</div>
                        </div>
                            <a href="user/new" className="btn btn-secondary">+ Nouvelle Utilisateur</a>
                    </div>

                    <div className="table-responsive">
                        <table className="table align-middle bg-white">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Login</th>
                                    <th>Roles</th>
                                    <th className="d-none d-md-table-cell">Email</th>
                                    <th>Remarque</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.map(user => (
                                    <tr key={user.id}>
                                        <td>{user.id}</td>
                                        <td>
                                            <div className="d-flex align-items-center gap-2">
                                                <span
                                                    className="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                    style={{ width: '32px', height: '32px', fontSize: '13px', fontWeight: 700 }}>
                                                        {user.login.charAt(0).toUpperCase()}
                                                </span>
                                                {user.login}
                                            </div>
                                        </td>
                                        <td>
                                            {user.roles.map(role => (
                                                <span key={role} className="badge badge-role rounded-pill me-1">{role}</span>
                                            ))}
                                        </td>
                                        <td className="d-none d-md-table-cell">{user.email}</td>
                                        <td className="text-muted">{user.remarque || '-'}</td>
                                        <td className="text-end">
                                            <a href={`/user/${user.id}`} className="me-2">Voir</a>
                                            {' '}
                                            <a href={`/user/${user.id}/edit`}>Modifier</a>
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