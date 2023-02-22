import React from "react";
export default function NavBar() {
    return (
        <div
            style={{
                alignItems: "center",
                display: "flex",
                justifyContent: "space-between",
                width: "100%",
            }}
        >
            <img src={"logo.svg"} />
            <div
                style={{
                    display: "flex",
                    width: "100%",
                    justifyContent: "space-evenly",
                }}
            >
                <a href="/">
                    <p>Features</p>
                </a>
                <a href="/legal">
                    <p>Legal</p>
                </a>
            </div>
            <button
                style={{
                    borderRadius: "10px",
                    color: "white",
                    width: "180px",
                    height: "60px",
                    background: "#FDBE49",
                }}
            >
                <p>Download App</p>
            </button>
        </div>
    );
}
