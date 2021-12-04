// Homepage class
class Homepage extends React.Component {
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
                        <a
                            href="./Shop"
                            class="fas fa-shopping-cart faCart"
                        ></a>
                    </div>
                    <div>
                        <a href="./User" class="fas fa-user faUser"></a>
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
        return (
            <main>
                <div id="mainItem">
                    <div>
                        <img
                            src="./public/Images/Items/(1135).jpg"
                            alt="Main Item"
                        />
                    </div>
                    <div>
                        <div>
                            <h1>League of Legends - Lee Sin Hoodie</h1>
                        </div>
                        <div>
                            <a href="./Hoodies/LeeSinHoodie">Shop Now</a>
                        </div>
                    </div>
                </div>
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
ReactDOM.render(<Homepage />, document.getElementById("app"));
