document.addEventListener("DOMContentLoaded", function () {
    function renderPost(post) {
        let blogPostsContainer = document.getElementById("blog-posts");

        // Create a post container
        const postContainer = document.createElement("div");
        postContainer.classList.add("post");

        // Create post content
        const postContent = `
            <div>
                <p><i>${post.dateOfPost}</i></p>
                <h1><i>${post.tittlePost}<i></h1>
                <p><img class="post-image" src="${post.imagePost}" alt="Post Image"></p>
                <div class="description-container">
                    <p>${post.descriptionPost}</p>
                </div>
                <p>${post.numberReactions} Reactions | ${post.numberComments} Comments</p> 
            </div>
            <hr>
        `;

        // Set post content to the post container
        postContainer.innerHTML = postContent;

        // Append the post container to the blog posts container
        blogPostsContainer.appendChild(postContainer);

        // Add click event listener to each image
        const postImages = postContainer.querySelectorAll('.post-image');
        postImages.forEach(image => {
            image.addEventListener('click', () => {
                openModal(image.src);
            });
        });
    }

    // Render each blog post
    fetch('get_posts.php')
        .then(response => response.json())
        .then(postsData => {
            const blogPostsContainer = document.getElementById("blog-posts");
            postsData.forEach(post => {
                renderPost(post);
                // Add a separator (hr) between posts for better visual separation
                const separator = document.createElement("hr");
                blogPostsContainer.appendChild(separator);

                // Call the renderPost function for each post
                
            });

        })
        .catch(error => console.error('Error fetching posts:', error));

    // Modal functions
    function openModal(imageSrc) {
        const modal = document.getElementById('myModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementById('closeBtn');
    
        modalImg.src = imageSrc;
    
        // Wait for the image to load before calculating its dimensions
        modalImg.onload = function() {
            // Calculate the position to center the image
            const topPosition = Math.max(0, (window.innerHeight - modalImg.height) / 2);
            const leftPosition = Math.max(0, (window.innerWidth - modalImg.width) / 2);
    
            // Set the position and display the modal
            modal.style.display = 'block';
            modal.style.top = topPosition + 'px';
            modal.style.left = leftPosition + 'px';
        };
    
        closeBtn.addEventListener('click', closeModal);
        window.addEventListener('click', outsideClick);
    }
    

    function closeModal() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }

    function outsideClick(e) {
        const modal = document.getElementById('myModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    }
});
