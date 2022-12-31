import styles from "../../css/page.css";
export default function Page({ children }) {
    return (
        <div className="page">
            <div className="pageContainer">{children}</div>
        </div>
    );
}
