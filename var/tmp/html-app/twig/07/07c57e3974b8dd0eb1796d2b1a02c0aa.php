<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Page/Index.html.twig */
class __TwigTemplate_566e6cc36fdea22522d097a78f554b48 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout/base.html.twig", "Page/Index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Weekday";
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "The weekday of ";
        echo twig_escape_filter($this->env, ($context["year"] ?? null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, ($context["month"] ?? null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, ($context["day"] ?? null), "html", null, true);
        echo " is ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["weekday"] ?? null), "weekday", [], "any", false, false, false, 4), "html", null, true);
        echo ".
";
    }

    public function getTemplateName()
    {
        return "Page/Index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 4,  54 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "Page/Index.html.twig", "/Users/tatsuo/MyVendor.Weekday/var/templates/Page/Index.html.twig");
    }
}
