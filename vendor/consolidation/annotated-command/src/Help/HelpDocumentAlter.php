<?php
namespace Consolidation\AnnotatedCommand\Help;

interface HelpDocumentAlter
{
    public function helpAlter(\DomDocument $dom);
}
