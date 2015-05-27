<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once 'config.php'; ?>
<?php require_once 'functions.php'; ?>
<?php logout(); ?>
<?php ob_end_flush(); ?>

