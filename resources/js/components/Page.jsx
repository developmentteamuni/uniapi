import React from "react";
export default function Page({ children }) {
    return (
        <div style={{ display: "flex", padding: "20px 40px" }}>{children}</div>
    );
}
