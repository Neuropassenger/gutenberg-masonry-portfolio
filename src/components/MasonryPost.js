const MasonryPost = (props) => {
    return (
        <div className="bws_masonry-post">
            <a href={props.postData.link}>
                <h2>{props.postData.title.rendered}</h2>
                <img 
                    loading="lazy" 
                    src={props.postData._embedded["wp:featuredmedia"][0].source_url} 
                    alt={props.postData.title.rendered} 
                />
            </a>
        </div>
    );
}

export default MasonryPost;