# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from django.db import models


class Wiki(models.Model):
    category = models.CharField(primary_key=True, max_length=20)
    full_name = models.CharField(max_length=40)
    shape = models.CharField(max_length=20, blank=True, null=True)
    weight = models.CharField(max_length=20, blank=True, null=True)
    alias = models.CharField(max_length=40, blank=True, null=True)
    ori_country = models.CharField(max_length=20, blank=True, null=True)
    height = models.CharField(max_length=20, blank=True, null=True)
    life = models.CharField(max_length=20, blank=True, null=True)
    base_info = models.TextField(blank=True, null=True)
    feature = models.TextField(blank=True, null=True)
    life_habit = models.TextField(blank=True, null=True)
    advantages_disadvantages = models.TextField(blank=True, null=True)
    feed_ways = models.TextField(blank=True, null=True)
    select_skill = models.TextField(blank=True, null=True)
    img = models.TextField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'wiki'
        unique_together = (('category', 'full_name'),)
