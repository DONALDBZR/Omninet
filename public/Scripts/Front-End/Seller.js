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
        return (
            <header>
                <div id="logo">
                    <a href="./">Omninet</a>
                </div>
                <nav>
                    <div>
                        <a href="./Profile" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a
                            href="./Logout"
                            class="fas fa-sign-out-alt faLogout"
                        ></a>
                    </div>
                </nav>
            </header>
        );
    }
}
// Main class
class Main extends React.Component {
    // Render method
    render() {
        return <main></main>;
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
