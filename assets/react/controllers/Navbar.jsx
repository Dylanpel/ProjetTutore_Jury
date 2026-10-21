import React from "react";

export default function Navbar({ login }) {
    return (
        <nav className="navbar navbar-expand-lg navbar-dark bg-white">
            <div className="container-fluid">
                <a className="navbar-brand text-dark" href="/">Bonjour le monde</a>

                <button
                    className="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarContent"
                    aria-controls="navbarContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarContent">
                    <ul className="navbar-nav me-auto">
                        <li className="nav-item">
                            <a className="nav-link text-dark" href="/user">Utilisateurs</a>
                        </li>
                    </ul>

                    {login && (
                        <div className="d-flex align-items-center gap-3 text-white">
                            <span>{login}</span>
                            <a href="/logout" className="btn btn-outline-light btn-sm">Se déconnecter</a>
                        </div>
                    )}
                </div>
            </div>
        </nav>
    )
}