<template>
  <div class="achievements-container">
    <!-- Header Section -->
    <div class="header-section">
      <h1 class="main-title">Achievements & Publications</h1>
      <p class="subtitle">Showcasing the awards, recognitions, and published research from the Vila Laboratory.</p>
    </div>

    <!-- Tabs Section -->
    <v-sheet elevation="0" class="tabs-wrapper">
      <v-tabs v-model="tab" color="primary" class="custom-tabs">
        <v-tab value="awards">Awards</v-tab>
        <v-tab value="publications">Publications</v-tab>
        <v-tab value="news">In the news</v-tab>
      </v-tabs>

      <v-divider></v-divider>

      <!-- Tabs Content -->
      <v-tabs-window v-model="tab">
        <!-- Awards Tab -->
        <v-tabs-window-item value="awards">
          <div class="tab-content">
            <h4 class="section-title">Awards & Recognitions</h4>
            <div class="award">
              <v-timeline align="start" side="end" class="custom-timeline">
                <v-timeline-item
                  v-for="award in awards"
                  :key="award.id"
                  dot-color="primary"
                  size="large"
                >
                  <template v-slot:icon>
                    <v-icon color="white">{{ award.icon }}</v-icon>
                  </template>

                  <div class="timeline-content">
                    <h3 class="award-title">{{ award.title }}</h3>
                    <p class="award-organization">{{ award.organization }}</p>
                  </div>
                </v-timeline-item>
              </v-timeline>
            </div>
          </div>
        </v-tabs-window-item>

        <!-- Publications Tab -->
        <v-tabs-window-item value="publications">
          <div class="publications-wrapper">
            <h4 class="pub-title">Published Research</h4>
            <div class="publication-list">
              <PublicationCard
                v-for="(pub, index) in publications"
                :key="index"
                :title="pub.title"
                :authors="pub.authors"
                :journal="pub.journal"
                :year="pub.year"
                @upload="handleUpload"
              />
            </div>
          </div>
        </v-tabs-window-item>

        <!-- In the news Tab -->
        <v-tabs-window-item value="news">
          <div class="news-wrapper">
            <h4 class="news-title">ViLa Lab in the News</h4>
            
            <!-- Featured Publication Card -->
            <div class="featured-publication">
              <PublicationCard
                :title="featuredNews.title"
                :authors="featuredNews.authors"
                :journal="featuredNews.journal"
                :year="featuredNews.year"
                @upload="handleUpload"
              />
            </div>

            <!-- News Cards Grid -->
            <div class="news-cards-grid">
              <NewsCard
                v-for="(news, index) in newsItems"
                :key="index"
                :source="news.source"
                :title="news.title"
                :date="news.date"
                :link="news.link"
              />
            </div>
          </div>
        </v-tabs-window-item>
      </v-tabs-window>
    </v-sheet>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import PublicationCard from '@/components/publication/PublicationCard.vue'
import NewsCard from '@/components/news/NewsCard.vue'

const tab = ref('awards')

const awards = ref([
  {
    id: 1,
    title: 'Best Paper Award',
    organization: 'NeurIPS 2023',
    icon: 'mdi-trophy'
  },
  {
    id: 2,
    title: 'Innovation in AI Grant',
    organization: 'National Science Foundation, 2022',
    icon: 'mdi-lightbulb'
  },
  {
    id: 3,
    title: 'Outstanding Dissertation Award',
    organization: 'ACM, 2021',
    icon: 'mdi-school'
  },
  {
    id: 4,
    title: 'Early Career Researcher Prize',
    organization: 'IEEE Computer Society, 2020',
    icon: 'mdi-account-star'
  }
])

const publications = ref([
  {
    title: 'Generative Adversarial Networks for Realistic Image Synthesis',
    authors: 'J. Doe, A. Smith, B. Johnson',
    journal: 'Journal of Vision and Learning',
    year: 2023
  },
  {
    title: 'Deep Learning Approaches for Natural Language Processing',
    authors: 'M. Chen, L. Wang, R. Brown',
    journal: 'ACM Transactions on Intelligent Systems',
    year: 2023
  },
  {
    title: 'Reinforcement Learning in Robotics: A Survey',
    authors: 'K. Lee, P. Davis, S. Martinez',
    journal: 'IEEE Robotics and Automation Letters',
    year: 2022
  }
])

const featuredNews = ref({
  title: 'Generative Adversarial Networks for Realistic Image Synthesis',
  authors: 'J. Doe, A. Smith, B. Johnson',
  journal: 'Journal of Vision and Learning',
  year: 2023
})

const newsItems = ref([
  {
    source: 'TechCrunch',
    title: "ViLa Lab's breakthrough AI could change medical diagnostics.",
    date: 'October 23, 2023',
    link: '#'
  },
  {
    source: 'Wired',
    title: 'The ethical implications of next-gen language models, featuring ViLa Lab experts.',
    date: 'August 14, 2023',
    link: '#'
  }
])

const handleUpload = ({ type, file }) => {
  console.log(type, file)
}
</script>

<style scoped>
.achievements-container {
  background-color: var(--color-bg);
  width: 100%;
  height: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 65px 156px;
}

/* Header Section */
.header-section {
  margin-bottom: 48px;
}

.main-title {
  font-weight: 700;
  color: var(--color-text);
  margin-bottom: 12px;
  text-align: start;
}

.subtitle {
  line-height: 1.6;
  text-align: start;
}

/* Tabs Wrapper */
.tabs-wrapper {
  background-color: transparent !important;
}

.custom-tabs {
  margin-bottom: 16px;
}

:deep(.v-tab) {
  text-transform: none;
  border: none;
  font-size: 16px;
  font-weight: 500;
  letter-spacing: normal;
}

:deep(.v-tab--selected) {
  color: var(--v-theme-primary);
}

.awards {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
}

/* Tab Content */
.tab-content {
  padding: 40px 20px;
}

.section-title {
  font-weight: 700;
  color: var(--color-text);
  margin-bottom: 40px;
  text-align: start;
}

/* Timeline Customization */
.custom-timeline {
  padding-left: 0px;
  margin-left: 0 !important;
  margin-right: auto !important;

}

/* Override Vuetify flex centering */
:deep(.v-timeline) {
  justify-content: flex-start !important;
}

:deep(.v-timeline-item) {
  min-height: 120px;   /* increase this */
  padding-bottom: 32px;
}

:deep(.v-timeline-divider__line) {
  min-height: 100%;
}

:deep(.v-timeline-divider) {
  padding-bottom: 60px;
}

:deep(.v-timeline-item__body) {
  padding-inline-start: 48px !important; /* default is small */
  align-items: flex-start !important;
  text-align: left;
}

:deep(.v-timeline-item:last-child) {
  padding-bottom: 0;
}

:deep(.v-timeline-divider__dot) {
  background-color: rgb(var(--v-theme-primary));
}

.timeline-content {
  padding-left: 24px;
}

.award-title {
  font-size: 18px;
  font-weight: 600;
  color: var(--color-text);
  margin-bottom: 4px;
}

.award-organization {
  font-size: 14px;
  color: #999;
  margin: 0;
}

.placeholder-text {
  color: #666;
  font-size: 16px;
}

/* Publications Section */

.publications-wrapper {
  padding: 40px 24px;
  flex-direction: column;
  align-items: center;
}

.pub-title {
  font-weight: 700;
  color: var(--color-text);
  margin-bottom: 60px;
  text-align: start;
}

.publication-list {
  width: 100%;
  max-width: 1128px;
  display: flex;
  flex-direction: column;
  gap: 25px;
  align-items: center;
}

/* News Section */
.news-wrapper {
  padding: 40px 24px;
  max-width: 1200px;
  margin: 0 auto;
}

.news-title {
  font-weight: 700;
  color: var(--color-text);
  margin-bottom: 60px;
  text-align: start;
}

.featured-publication {
  width: 100%;
  max-width: 1128px;
  margin: 0 auto 40px;
}

.news-cards-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  max-width: 1128px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .news-cards-grid {
    grid-template-columns: 1fr;
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .achievements-container {
    padding: 40px 20px;
  }

  .main-title {
    font-size: 28px;
  }

  .section-title {
    font-size: 24px;
  }

  .tab-content {
    padding: 30px 10px;
  }
}
</style>