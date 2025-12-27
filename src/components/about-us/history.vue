<template>
    <div class="wrapper">
        <div class="header">
            <span class="subtitle">The history of</span>
            <h1 class="title">ViLa Lab</h1>
        </div>
        
        <div class="content-container">
            <div class="text-content">
                <p class="description">
                    <span class="drop-cap">L</span>ed by Dr. Dona Valy, researcher/lecturer of ITC. ViLa Lab is a dedicated research laboratory under the Mechatronics and Information Technology (MIT) Research Unit and the Department of Information and Communication Engineering (GIC) at ITC.
                </p>
                <p class="description">
                    It focuses on Computer Vision and Natural Language Processing (NLP) research, particularly for Khmer language applications. The lab provides a collaborative research environment primarily for graduate students (Master’s and PhD), while also welcoming undergraduate students (Year 2 to Year 5) to develop their research skills early. Undergraduate students typically work alongside their senior graduate counterparts, fostering mentorship and practical experience.
                </p>
            </div>
            <div class="image-content">
                <img src="@/assets/about-us/banner2.png" alt="ViLa Lab Team" class="history-image" />
            </div>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
.wrapper {
    margin-top: 40px;
    margin-bottom: 76px;
    padding-inline: 156px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.header {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.subtitle {
    font-size: 18px;
    color: var(--color-primary);
    font-weight: 500;
}

.title {
    font-size: 36px;
    color: var(--color-primary);
    font-weight: 800;
    margin: 0;
}

.content-container {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    gap: 40px;
}

.text-content {
    flex: 1;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.description {
    font-size: 16px;
    line-height: 1.6;
    color: var(--color-text);
    text-align: justify;
}

.drop-cap {
    font-size: 48px;
    font-weight: bold;
    float: left;
    line-height: 0.8;
    padding-right: 4px;
    padding-top: 4px; /* Adjust to align with text */
}

.image-content {
    flex: 1;
}

.history-image {
    width: 100%;
    height: auto;
    border-radius: 20px;
    object-fit: cover;
}

@media (max-width: 1024px) {
    .wrapper {
        padding-inline: 40px;
    }
}

@media (max-width: 768px) {
    .content-container {
        flex-direction: column;
    }
    
    .wrapper {
        padding-inline: 20px;
    }

    .image-content {
        width: 100%;
    }
}
</style>
