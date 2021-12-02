// Homepage class
class Homepage extends React.Component {
    // Render method
    render() {
        return [<Header />];
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
// Rendering the page
ReactDOM.render(<Homepage />, document.getElementById("app"));
