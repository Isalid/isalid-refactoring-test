<?php

declare(strict_types=1);

class TemplateManager
{
    /**
     * @param AbstractTemplateProcessor[] $processors
     */
    public function __construct(private array $processors)
    {
    }

    public function getTemplateComputed(Template $tpl, array $data): Template
    {
        $templateData = $this->processDataForTemplate($data);

        return $this->render($tpl, $templateData);
    }

    private function processDataForTemplate(array $data): array
    {
        return [
            $data['quote'] ?? null,
            ($data['user'] ?? null) instanceof User ? $data['user'] : (ApplicationContext::getInstance())->getCurrentUser(),
        ];
    }

    private function render($tpl, array $templateData): Template
    {
        $subject = $tpl->subject;
        $content = $tpl->content;
        foreach ($templateData as $data) {
            foreach ($this->processors as $processor) {
                $subject = $processor->process($subject, $data);
                $content = $processor->process($content, $data);
            }
        }

        // We can't change signature of getTemplateComputed.
        // So we continue to return a Template but in futur, it is better to have 2 objects. Ex: Template & Response
        return new Template(
            $tpl->id,
            $subject,
            $content,
        );
    }
}
