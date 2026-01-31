<template>
    <div class="banner">
        <img src="/src/assets/become-member/banner.png" alt="become member banner">
    </div>
    <div class="content">   
        <h2>About Recruitment Process</h2>
        <p>Our lab is committed to providing a supportive environment for undergraduate and master's students to conduct research in Computer Vision and Natural Language Processing. Through mentorship and collaboration, we aim to equip our students with the skills and knowledge needed to become successful researchers and practitioners in these fields.</p>
    </div>
    <div class="eligibility">
        <h2>Eligibility</h2>
        <div class="card-container">
            <div class="eligibility-card">
                <div class="header">
                    <Icon class="icon" icon="tdesign:education-filled"></Icon>
                    <h3>Educational Background</h3>
                </div>
                <ul>
                    <li>Undergraduates students (Year 2- Year 5)</li>
                    <li>Graduates students (Master’s and PhD)</li>
                </ul>
            </div>
            <div class="eligibility-card">
                <div class="header">
                    <Icon class="icon" icon="streamline-plump:graph-bar-increase-solid"></Icon>
                    <h3>Key Deliverable</h3>
                </div>
                <ul>
                    <li>Consistent and dedicated contribution to research tasks.</li>
                    <li>Effective time management to meet research milestones and maintain steady progress.</li>
                    <li>Active participation in lab meetings, workshops, and collaborative activities.</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
</script>

<style scoped>
.banner{
    width: 100%;
    padding: 0;
    display: flex;
    object-fit: fill;
    background-color: antiquewhite;
}
.banner img{
    width: 100%;
    height: auto;
    display: flex;
    object-fit: cover;
}
.content{
    padding-top: 40px;
    padding-inline: 25%;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.eligibility{
    margin-top: 56px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    align-items: flex-start;
    padding-inline: 15%;
}
.card-container{
    display: flex; 
    flex-direction: row;
    gap: 32px;
}
.eligibility-card{
    padding: 65px 50px 65px 50px;
    background-color: var(--color-secondary);
    border-radius: 40px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    align-items: flex-start;
}
.header{
    display: flex;
    flex-direction: row;
    gap: 15px;
    text-transform: uppercase;
    align-items: center;
}
.header h3{
    width: 50%;
    text-align: left;
}
.icon{
    width: 65px;
    height: 65px;
    color: var(--color-primary);
}
ul {
  list-style: disc;
  padding-left: 20px;
  text-align: left;
  gap: 20px;
}
li{
    margin-bottom: 12px;
}

@media (max-width: 1024px) {
  .content {
    padding-inline: 15%;
  }

  .eligibility {
    padding-inline: 10%;
  }

  .card-container {
    gap: 24px;
  }

  .eligibility-card {
    padding: 40px;
  }
}

@media (max-width: 768px) {
  .content {
    padding-inline: 8%;
  }

  .eligibility {
    padding-inline: 8%;
    align-items: stretch;
  }

  .card-container {
    flex-direction: column;
  }

  .eligibility-card {
    padding: 32px;
    border-radius: 24px;
  }

  .header h3 {
    width: 100%;
    font-size: 1rem;
  }

  .icon {
    width: 48px;
    height: 48px;
  }
}
@media (max-width: 480px) {
  .content {
    padding-inline: 5%;
  }

  .eligibility {
    padding-inline: 5%;
  }

  h2 {
    font-size: 1.3rem;
  }

  p, li {
    font-size: 0.95rem;
  }

  .eligibility-card {
    padding: 24px;
  }
}

</style>