import { onMounted, onUnmounted } from 'vue';
import { animate, stagger } from 'motion';

interface AnimationConfig {
    selector: string;
    animation: object;
    options?: object;
    staggerDelay?: number;
}

export function useScrollAnimation(configs: AnimationConfig[]) {
    let observer: IntersectionObserver | null = null;
    const animatedElements = new Set<Element>();

    const handleIntersection = (entries: IntersectionObserverEntry[]) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !animatedElements.has(entry.target)) {
                animatedElements.add(entry.target);

                // Find matching config for this element
                const config = configs.find(c => entry.target.matches(c.selector));
                if (config) {
                    if (config.staggerDelay) {
                        // For stagger animations, find all matching elements within this section
                        const parentElement = entry.target.closest('section') || document;
                        const elements = parentElement.querySelectorAll(config.selector);

                        if (elements.length > 0) {
                            animate(elements, config.animation, {
                                ...config.options,
                                delay: stagger(config.staggerDelay)
                            });

                            // Mark all stagger elements as animated to prevent duplicate animations
                            elements.forEach(el => animatedElements.add(el));
                        }
                    } else {
                        // Single element animation
                        animate(entry.target, config.animation, config.options);
                    }
                }
            }
        });
    };

    onMounted(() => {
        // Wait for DOM to be ready
        setTimeout(() => {
            observer = new IntersectionObserver(handleIntersection, {
                threshold: 0.1,
                rootMargin: '0px 0px -20% 0px'
            });

            // Observe all elements that match our selectors
            configs.forEach(config => {
                const elements = document.querySelectorAll(config.selector);
                elements.forEach(element => {
                    observer?.observe(element);
                });
            });
        }, 100);
    });

    onUnmounted(() => {
        observer?.disconnect();
    });

    return {
        observer
    };
}
