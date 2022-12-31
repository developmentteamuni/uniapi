import { Head } from "@inertiajs/inertia-react";
import NavBar from "../Components/NavBar";
import WelcomeHero from "../Components/WelcomeHero";
import Page from "../Layouts/Page";
import FeatureCards from "@/Components/FeatureCards";
// TODO: Figure out a better way to inject css files
import styles from "../../css/welcome.css";
export default function Welcome(props) {
    return (
        <>
            <Head title="Welcome" />
            <Page>
                <NavBar />
                <WelcomeHero />
                <FeatureCards />
            </Page>
        </>
    );
}
