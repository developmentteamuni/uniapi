import styles from "../../css/navbar.css";
//TODO: Figure out a way to keep our controller paths consistent with navbar constant
const pages = {
    EVENTS: "Events",
    FEATURES: "Features",
    LEGAL: "Legal",
};

export default function NavBar() {
    return (
        <div className="navBar">
            <img className="logo" src={"logo.svg"} />
            <div className="navItems">
                {Object.keys(pages).map((item) => {
                    return (
                        <a key={item} href="/dashboard">
                            {pages[item]}
                        </a>
                    );
                })}
            </div>
            <button className="downloadButton">
                <div>Download App</div>
            </button>
        </div>
    );
}
