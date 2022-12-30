import { Link, Head } from "@inertiajs/inertia-react";
// TODO: Figure out a better way to inject css files
import styles from "../../css/welcome.css";
const pages = {
    EVENTS: "Events",
    FEATURES: "Features",
    LEGAL: "Legal",
};
export default function Welcome(props) {
    return (
        <>
            <Head title="Welcome" />
            <div className="navBar">
                <img className="logo" src={"logo.svg"} />
                <div className="navItems">
                    {Object.keys(pages).map((item) => {
                        return <a href="/dashboard">{pages[item]}</a>;
                    })}
                </div>
                <button className="downloadButton">
                    <div>Download App</div>
                </button>
            </div>
        </>
    );
}
