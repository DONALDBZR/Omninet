// Seller class
class Seller extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
// Header class
class Header extends React.Component {
    // Render method
    render() {
        return <header>Omninet</header>;
    }
}
// Main class
class Main extends React.Component {
    // Render method
    render() {
        return (
            <main>
                <h1>Bye! We hope to see you again!</h1>
            </main>
        );
    }
}
// Footer class
class Footer extends React.Component {
    // Render method
    render() {
        return <footer>Omninet</footer>;
    }
}
// Rendering the page
ReactDOM.render(<Seller />, document.getElementById("app"));
