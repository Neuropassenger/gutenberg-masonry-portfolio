const MasonryPost = (props) => {
    return (
        <div className="bws_masonry-post">
            <a href={props.postData.link}>
                <img src={props.postData._embedded["wp:featuredmedia"][0].source_url} alt={props.postData.title.rendered} />
            </a>
        </div>
    );
}

export default MasonryPost;