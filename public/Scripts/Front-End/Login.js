// Login class
class Login extends React.Component {
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
                <nav id="catalog">
                    <div>
                        <a href="./Shop">Shops</a>
                    </div>
                    <div>
                        <a href="./Brand">Brands</a>
                    </div>
                </nav>
                <nav id="utilities">
                    <div>
                        <a href="./User" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a href="./Search" class="fas fa-search faSearch"></a>
                    </div>
                    <div>
                        <a
                            href="./Cart"
                            class="fas fa-shopping-cart faCart"
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
        return (
            <main>
                {/* <div id="mainItem">
                    <div>
                        <img
                            src="./public/Images/Items/mock-hoodie-new_200056db-691b-4ca5-afcf-b3c2163694aa_1024x1024@2x.jpg"
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
                </div> */}
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
ReactDOM.render(<Login />, document.getElementById("app"));
