const MasonryNavigation = (props) => {
    return (
        <ul className="bws_gutenberg-masonry-portfolio-filter">
            <li 
                className={props.selectedCategories.length == 0 ? "bws_selected-category-item" : ""} 
                onClick={(event) => props.categoryOnClick(-1)}
            >
                All Categories
            </li>
            {props.categories.list.map((category) => {
                return (
                    <li 
                        className={props.selectedCategories.includes(category.id) ? "bws_selected-category-item" : ""} 
                        onClick={(event) => props.categoryOnClick(category.id)}
                    >
                        {category.name}
                    </li>
                );
            })}
        </ul>
    );
}

export default MasonryNavigation;